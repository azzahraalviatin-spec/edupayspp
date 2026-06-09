<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\SettingSpp;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Notifications\TagihanBaru;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PembayaranMasukAdmin;
use App\Models\User;


class TagihanController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        $tahunAktif   = TahunAjaran::where('is_aktif', true)->first();
        $bulanList    = $this->bulanList();

        return view('petugas.tagihan.generate', compact('tahunAjarans', 'tahunAktif', 'bulanList'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
            'bulan'           => 'required|integer|between:1,12',
        ]);

        $bulanGenerate = (int) $request->bulan;
        $tahunGenerate = (int) now()->year;

        $siswas    = Siswa::where('status', 'aktif')->with('kelas')->get();
        $generated = 0;
        $skipped   = 0;

        foreach ($siswas as $siswa) {

            // ⬇️ LOGIKA PEMBATASAN KELAS 12 DI SINI ⬇️
            // Jika bulan Mei (5) atau Juni (6) DAN siswa tingkat kelasnya 'XII', maka skip!
            if (($bulanGenerate == 5 || $bulanGenerate == 6) && optional($siswa->kelas)->tingkat == 'XII') {
                $skipped++;
                continue; 
            }
            // ⬆️ LOGIKA PEMBATASAN KELAS 12 Selesai ⬆️

            // Cek tagihan bulan ini sudah ada belum
            $exists = Tagihan::where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
                ->where('bulan', $bulanGenerate)
                ->exists();

            if ($exists) { $skipped++; continue; }

            // Ambil setting SPP kelas
            $setting     = SettingSpp::where('kelas_id', $siswa->kelas_id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id)->first();
            $nominalAwal = $setting ? $setting->nominal : 0;

            // Hitung potongan yang masih berlaku di bulan+tahun generate
            $totalPotongan = $siswa->potonganSpps()
                ->wherePivot('is_aktif', true)
                ->where(function($q) use ($bulanGenerate, $tahunGenerate) {
                    $q->where(function($q) use ($bulanGenerate, $tahunGenerate) {
                        $q->where('siswa_potongan.tahun_mulai', '<', $tahunGenerate)
                          ->orWhere(function($q) use ($bulanGenerate, $tahunGenerate) {
                              $q->where('siswa_potongan.tahun_mulai', '=', $tahunGenerate)
                                ->where('siswa_potongan.bulan_mulai', '<=', $bulanGenerate);
                          });
                    });
                })
                ->where(function($q) use ($bulanGenerate, $tahunGenerate) {
                    $q->where(function($q) use ($bulanGenerate, $tahunGenerate) {
                        $q->where('siswa_potongan.tahun_selesai', '>', $tahunGenerate)
                          ->orWhere(function($q) use ($bulanGenerate, $tahunGenerate) {
                              $q->where('siswa_potongan.tahun_selesai', '=', $tahunGenerate)
                                ->where('siswa_potongan.bulan_selesai', '>=', $bulanGenerate);
                          });
                    });
                })
                ->sum('nominal_potongan');

            $nominalBayar = max(0, $nominalAwal - $totalPotongan);

          $tagihan = Tagihan::create([
    'siswa_id'        => $siswa->id,
    'tahun_ajaran_id' => $request->tahun_ajaran_id,
    'bulan'           => $bulanGenerate,
    'nominal_awal'    => $nominalAwal,
    'total_potongan'  => $totalPotongan,
    'nominal_bayar'   => $nominalBayar,
    'status'          => 'belum_bayar',
]);

if ($siswa->user) {
    $siswa->user->notify(new TagihanBaru($tagihan));
}

$generated++;
        }

        return redirect()->route('petugas.tagihan.generate')
            ->with('success', "Berhasil generate $generated tagihan! $skipped tagihan sudah ada atau dilewati (Kelas XII pada Mei/Juni).");
    }

    /**
     * Daftar siswa tunggakan bulan ini
     */
    public function tunggakan()
    {
        $tahunAktif = TahunAjaran::where('is_aktif', true)->first();
        $bulanIni   = now()->month;

        $tunggakan = Siswa::with([
                'kelas',
                'tagihans' => function ($q) use ($tahunAktif, $bulanIni) {
                    $q->where('status', 'belum_bayar')
                      ->where('bulan', $bulanIni)
                      ->when($tahunAktif, fn($q) => $q->where('tahun_ajaran_id', $tahunAktif->id))
                      ->select('id', 'siswa_id', 'bulan', 'status', 'nominal_bayar', 'tahun_ajaran_id');
                }
            ])
            ->whereHas('tagihans', function ($q) use ($tahunAktif, $bulanIni) {
                $q->where('status', 'belum_bayar')
                  ->where('bulan', $bulanIni)
                  ->when($tahunAktif, fn($q) => $q->where('tahun_ajaran_id', $tahunAktif->id));
            })
            ->withSum(['tagihans as total_tunggakan' => function ($q) use ($tahunAktif, $bulanIni) {
                $q->where('status', 'belum_bayar')
                  ->where('bulan', $bulanIni)
                  ->when($tahunAktif, fn($q) => $q->where('tahun_ajaran_id', $tahunAktif->id));
            }], 'nominal_bayar')
            ->orderBy('nama')
            ->get();

        return view('petugas.tagihan.tunggakan', compact('tunggakan', 'tahunAktif'))
            ->with('bulanList', $this->bulanList());
    }

    /**
     * Halaman form pembayaran tunai
     */
    public function showBayar($id)
    {
        $tagihan = Tagihan::with('siswa.kelas')->findOrFail($id);

        if ($tagihan->status === 'lunas') {
            return redirect()->route('petugas.tunggakan')
                ->with('error', 'Tagihan ini sudah lunas!');
        }

        $potonganAktif = $tagihan->siswa->potonganSpps()
            ->wherePivot('is_aktif', true)
            ->where(function($q) use ($tagihan) {
                $bulan = $tagihan->bulan;
                $tahun = now()->year;
                $q->where(function($q) use ($bulan, $tahun) {
                    $q->where('siswa_potongan.tahun_mulai', '<', $tahun)
                      ->orWhere(function($q) use ($bulan, $tahun) {
                          $q->where('siswa_potongan.tahun_mulai', '=', $tahun)
                            ->where('siswa_potongan.bulan_mulai', '<=', $bulan);
                      });
                });
            })
            ->where(function($q) use ($tagihan) {
                $bulan = $tagihan->bulan;
                $tahun = now()->year;
                $q->where(function($q) use ($bulan, $tahun) {
                    $q->where('siswa_potongan.tahun_selesai', '>', $tahun)
                      ->orWhere(function($q) use ($bulan, $tahun) {
                          $q->where('siswa_potongan.tahun_selesai', '=', $tahun)
                            ->where('siswa_potongan.bulan_selesai', '>=', $bulan);
                      });
                });
            })
            ->get();

        return view('petugas.tagihan.bayar', [
            'tagihan'       => $tagihan,
            'bulanList'     => $this->bulanList(),
            'potonganAktif' => $potonganAktif,
        ]);
    }

    /**
     * Proses bayar tunai
     */
  public function bayarTunai(Request $request, $id)
{
    $tagihan = Tagihan::findOrFail($id);

    if ($tagihan->status === 'lunas') {
        return redirect()->route('petugas.tunggakan')
            ->with('error', 'Tagihan ini sudah lunas!');
    }

    $request->validate([
        'uang_dibayar' => 'required|numeric|min:1',
    ]);

    $totalBayar  = $tagihan->nominal_bayar;
    $uangDibayar = $request->uang_dibayar;

    if ($uangDibayar < $totalBayar) {
        return back()->with('error', 'Uang pembayaran kurang!');
    }

    $kembalian = $uangDibayar - $totalBayar;

    $pembayaran = Pembayaran::create([
        'tagihan_id'        => $tagihan->id,
        'jumlah_bayar'      => $totalBayar,
        'uang_dibayar'      => $uangDibayar,
        'kembalian'         => $kembalian,
        'metode_pembayaran' => 'tunai',
        'status_verifikasi' => 'valid',
        'tanggal_bayar'     => now(),
        'petugas_id'        => Auth::id(),
        'no_kwitansi'       => 'KW-' . time(),
    ]);

    $tagihan->update(['status' => 'lunas']);

    // === KIRIM NOTIFIKASI KE SEMUA ADMIN ===
    $admins = User::role('admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new PembayaranMasukAdmin($pembayaran));
    }
    // =======================================

    return redirect()->route('petugas.struk', $pembayaran->id);
}
    public function struk($id)
    {
        $pembayaran = Pembayaran::with([
            'tagihan.siswa.kelas',
            'petugas',
        ])->findOrFail($id);

        return view('petugas.tagihan.struk', [
            'pembayaran' => $pembayaran,
            'bulanList'  => $this->bulanList(),
        ]);
    }

    public function tunggakanDetail($id)
    {
        $tagihan = Tagihan::with([
            'siswa.kelas',
            'siswa.potonganSpps'
        ])->findOrFail($id);

        return view('petugas.tagihan.detail', [
            'tagihan'   => $tagihan,
            'bulanList' => $this->bulanList(),
        ]);
    }

    private function bulanList(): array
    {
        return [
            1  => 'Januari',  2 => 'Februari', 3  => 'Maret',
            4  => 'April',    5 => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8 => 'Agustus',   9  => 'September',
            10 => 'Oktober', 11 => 'November', 12  => 'Desember',
        ];
    }
}