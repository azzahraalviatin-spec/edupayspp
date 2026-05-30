<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\PotonganSpp;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PotonganController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with(['kelas', 'potonganSpps' => function($q) {
            $q->wherePivot('is_aktif', true);
        }])->where('status', 'aktif')->orderBy('nama')->get();

        $potongan = PotonganSpp::orderBy('jenis')->orderBy('nama')->get();

        $totalPotonganPerBulan = $siswas->sum(function($siswa) {
            return $siswa->potonganSpps->sum('nominal_potongan');
        });

        $totalSiswaDapatPotongan = $siswas->filter(fn($s) => $s->potonganSpps->count() > 0)->count();

        $totalPemerintah = $siswas->sum(function($siswa) {
            return $siswa->potonganSpps->where('jenis', 'pemerintah')->sum('nominal_potongan');
        });

        $totalPrestasi = $siswas->sum(function($siswa) {
            return $siswa->potonganSpps->where('jenis', 'prestasi')->sum('nominal_potongan');
        });

        return view('petugas.potongan.index', compact(
            'siswas', 'potongan',
            'totalPotonganPerBulan', 'totalSiswaDapatPotongan',
            'totalPemerintah', 'totalPrestasi'
        ));
    }

    public function tambah($jenis)
    {
        $siswas = Siswa::with('kelas')
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $bulanList = $this->bulanList();

        return view('petugas.potongan.tambah', compact('siswas', 'jenis', 'bulanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_penerima'  => 'required',
            'jenis'            => 'required|in:pemerintah,prestasi',
            'nama'             => 'required|string|max:255',
            'nominal_potongan' => 'required|numeric|min:1',
            'bulan_mulai'      => 'required|integer|between:1,12',
            'tahun_mulai'      => 'required|digits:4',
            'bulan_selesai'    => 'required|integer|between:1,12',
            'tahun_selesai'    => 'required|digits:4',
            'keterangan'       => 'nullable|string|max:255',
        ]);

        $mulai   = ($request->tahun_mulai * 12) + $request->bulan_mulai;
        $selesai = ($request->tahun_selesai * 12) + $request->bulan_selesai;

        if ($selesai < $mulai) {
            return back()->withInput()
                ->with('error', 'Bulan selesai tidak boleh sebelum bulan mulai!');
        }

        $potongan = PotonganSpp::create([
            'nama'             => $request->nama,
            'jenis'            => $request->jenis,
            'nominal_potongan' => $request->nominal_potongan,
        ]);

        $target = $request->target_penerima;

        if ($target === 'semua') {
            $siswas = Siswa::where('status', 'aktif')->get();
        } elseif (in_array($target, ['10', '11', '12'])) {
            $siswas = Siswa::where('status', 'aktif')
                ->whereHas('kelas', fn($q) => $q->where('tingkat', $target))
                ->get();
        } elseif ($target === 'siswa_tertentu') {
            $request->validate(['siswa_id' => 'required|exists:siswas,id']);
            $siswas = Siswa::where('id', $request->siswa_id)->get();
        } else {
            $siswas = collect();
        }

        foreach ($siswas as $siswa) {
            $siswa->potonganSpps()->attach($potongan->id, [
                'bulan_mulai'   => $request->bulan_mulai,
                'tahun_mulai'   => $request->tahun_mulai,
                'bulan_selesai' => $request->bulan_selesai,
                'tahun_selesai' => $request->tahun_selesai,
                'is_aktif'      => true,
                'keterangan'    => $request->keterangan,
            ]);
        }

        return redirect()->route('petugas.potongan')
            ->with('success', 'Potongan berhasil ditambahkan untuk ' . $siswas->count() . ' siswa!');
    }

    public function detail($siswaId, $potonganId)
    {
        $siswa    = Siswa::with('kelas')->findOrFail($siswaId);
        $potongan = PotonganSpp::findOrFail($potonganId);

        $pivot = $siswa->potonganSpps()
            ->wherePivot('potongan_spp_id', $potonganId)
            ->first()?->pivot;

        if (!$pivot) {
            return redirect()->route('petugas.potongan')
                ->with('error', 'Data potongan tidak ditemukan!');
        }

        $bulanList = $this->bulanList();

        return view('petugas.potongan.detail', compact('siswa', 'potongan', 'pivot', 'bulanList'));
    }

    public function editPotongan($siswaId, $potonganId)
    {
        $siswa    = Siswa::with('kelas')->findOrFail($siswaId);
        $potongan = PotonganSpp::findOrFail($potonganId);

        $pivot = $siswa->potonganSpps()
            ->wherePivot('potongan_spp_id', $potonganId)
            ->first()?->pivot;

        if (!$pivot) {
            return redirect()->route('petugas.potongan')
                ->with('error', 'Data potongan tidak ditemukan!');
        }

        $bulanList = $this->bulanList();

        // Hitung jumlah siswa per kelas yang punya potongan ini
        $jumlahPerKelas = [
            'semua' => Siswa::whereHas('potonganSpps', fn($q) => $q->where('potongan_spp_id', $potonganId))->count(),
            '10'    => Siswa::whereHas('kelas', fn($q) => $q->where('tingkat', '10'))
                            ->whereHas('potonganSpps', fn($q) => $q->where('potongan_spp_id', $potonganId))->count(),
            '11'    => Siswa::whereHas('kelas', fn($q) => $q->where('tingkat', '11'))
                            ->whereHas('potonganSpps', fn($q) => $q->where('potongan_spp_id', $potonganId))->count(),
            '12'    => Siswa::whereHas('kelas', fn($q) => $q->where('tingkat', '12'))
                            ->whereHas('potonganSpps', fn($q) => $q->where('potongan_spp_id', $potonganId))->count(),
        ];

        return view('petugas.potongan.edit', compact('siswa', 'potongan', 'pivot', 'bulanList', 'jumlahPerKelas'));
    }

    public function updatePotongan(Request $request, $siswaId, $potonganId)
    {
        $request->validate([
            'jenis'            => 'required|in:pemerintah,prestasi',
            'nama'             => 'required|string|max:255',
            'nominal_potongan' => 'required|numeric|min:1',
            'bulan_mulai'      => 'required|integer|between:1,12',
            'tahun_mulai'      => 'required|digits:4',
            'bulan_selesai'    => 'required|integer|between:1,12',
            'tahun_selesai'    => 'required|digits:4',
            'keterangan'       => 'nullable|string|max:255',
            'update_target'    => 'required|in:satu,semua,10,11,12',
        ]);

        $mulai   = ($request->tahun_mulai * 12) + $request->bulan_mulai;
        $selesai = ($request->tahun_selesai * 12) + $request->bulan_selesai;

        if ($selesai < $mulai) {
            return back()->withInput()
                ->with('error', 'Bulan selesai tidak boleh sebelum bulan mulai!');
        }

        // Update data potongan utama
        $potongan = PotonganSpp::findOrFail($potonganId);
        $potongan->update([
            'nama'             => $request->nama,
            'jenis'            => $request->jenis,
            'nominal_potongan' => $request->nominal_potongan,
        ]);

        $pivotData = [
            'bulan_mulai'   => $request->bulan_mulai,
            'tahun_mulai'   => $request->tahun_mulai,
            'bulan_selesai' => $request->bulan_selesai,
            'tahun_selesai' => $request->tahun_selesai,
            'keterangan'    => $request->keterangan,
        ];

        $target = $request->update_target;

        if ($target === 'satu') {
            // Update hanya 1 siswa ini
            $siswa = Siswa::findOrFail($siswaId);
            $siswa->potonganSpps()->updateExistingPivot($potonganId, $pivotData);
            $jumlah = 1;
        } else {
            // Update massal
            $query = Siswa::whereHas('potonganSpps', fn($q) => $q->where('potongan_spp_id', $potonganId));

            if (in_array($target, ['10', '11', '12'])) {
                $query->whereHas('kelas', fn($q) => $q->where('tingkat', $target));
            }

            $siswas = $query->get();
            foreach ($siswas as $s) {
                $s->potonganSpps()->updateExistingPivot($potonganId, $pivotData);
            }
            $jumlah = $siswas->count();
        }

        return redirect()->route('petugas.potongan')
            ->with('success', "Potongan berhasil diperbarui untuk {$jumlah} siswa!");
    }

    public function hapus($siswaId, $potonganId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $siswa->potonganSpps()->detach($potonganId);

        $potongan = PotonganSpp::find($potonganId);
        if ($potongan && $potongan->siswas()->count() === 0) {
            $potongan->delete();
        }

        return redirect()->route('petugas.potongan')
            ->with('success', 'Potongan berhasil dihapus!');
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