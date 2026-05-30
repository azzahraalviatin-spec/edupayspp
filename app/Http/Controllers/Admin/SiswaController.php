<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\TahunAjaran;
use App\Models\SettingSpp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->has('status') && $request->status == 'belum_bayar') {
            $query->whereHas('tagihans', function($q) {
                $q->where('status', 'belum_bayar');
            });
        }

        $siswas = $query->orderBy('nama')->get();

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|string|max:20|unique:siswas,nis',
            'nama'          => 'required|string|max:100',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp_ortu'    => 'nullable|string|max:20',
            'nama_ortu'     => 'nullable|string|max:100',
            'tahun_masuk'   => 'required|digits:4',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'nis'      => $request->nis,
            'password' => Hash::make($request->nis),
        ]);
        $user->assignRole('siswa');

        $siswa = Siswa::create([
            'user_id'       => $user->id,
            'kelas_id'      => $request->kelas_id,
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp_ortu'    => $request->no_hp_ortu,
            'nama_ortu'     => $request->nama_ortu,
            'tahun_masuk'   => $request->tahun_masuk,
            'status'        => 'aktif',
        ]);

        $this->generateTagihanOtomatis($siswa);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'           => 'required|string|max:20|unique:siswas,nis,' . $siswa->id,
            'nama'          => 'required|string|max:100',
            'kelas_id'      => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp_ortu'    => 'nullable|string|max:20',
            'nama_ortu'     => 'nullable|string|max:100',
            'tahun_masuk'   => 'required|digits:4',
            'status'        => 'required|in:aktif,alumni',
        ]);

        // Update data siswa
        $siswa->update([
            'nis'           => $request->nis,
            'nama'          => $request->nama,
            'kelas_id'      => $request->kelas_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp_ortu'    => $request->no_hp_ortu,
            'nama_ortu'     => $request->nama_ortu,
            'tahun_masuk'   => $request->tahun_masuk,
            'status'        => $request->status,
        ]);

        // Sinkron NIS & nama ke tabel users otomatis
        $siswa->user->update([
            'nis'  => $request->nis,
            'name' => $request->nama,
        ]);

        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->user->delete();
        $siswa->delete();
        return redirect()->route('admin.siswa.index')
                         ->with('success', 'Siswa berhasil dihapus!');
    }

    public function show($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    private function generateTagihanOtomatis(Siswa $siswa)
    {
        $tahunAjaran = TahunAjaran::where('is_aktif', 1)->first();
        if (!$tahunAjaran) return;

        $settingSpp = SettingSpp::where('kelas_id', $siswa->kelas_id)
                                ->where('tahun_ajaran_id', $tahunAjaran->id)
                                ->first()
                  ?? SettingSpp::where('tahun_ajaran_id', $tahunAjaran->id)->first();

        if (!$settingSpp) return;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $sudahAda = Tagihan::where('siswa_id', $siswa->id)
                               ->where('tahun_ajaran_id', $tahunAjaran->id)
                               ->where('bulan', $bulan)
                               ->exists();

            if (!$sudahAda) {
                Tagihan::create([
                    'siswa_id'        => $siswa->id,
                    'tahun_ajaran_id' => $tahunAjaran->id,
                    'bulan'           => $bulan,
                    'nominal_awal'    => $settingSpp->nominal,
                    'total_potongan'  => 0,
                    'nominal_bayar'   => $settingSpp->nominal,
                    'status'          => 'belum_bayar',
                ]);
            }
        }
    }
}