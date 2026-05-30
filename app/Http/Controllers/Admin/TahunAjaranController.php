<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        return view('admin.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    // FUNGSI STORE: Sudah digabung rapi, pintar, dan anti-kembar
    public function store(Request $request)
    {
        // 1. Gabungkan input tahun_mulai & tahun_selesai dari form baru menjadi format "2025/2026"
        $tahunAjaranGabung = $request->tahun_mulai . '/' . $request->tahun_selesai;
        
        // 2. Selipkan ke dalam request agar dibaca sebagai 'nama'
        $request->merge(['nama' => $tahunAjaranGabung]);

        // 3. Jalankan validasi ketat anti-kembar yang sopan
        $request->validate([
            'nama' => 'required|string|unique:tahun_ajarans,nama',
        ], [
            'nama.unique' => 'Maaf, Tahun Ajaran ' . $tahunAjaranGabung . ' sudah terdaftar di sistem. Silakan periksa kembali data Anda.',
        ]);

        // 4. Hitung tanggal mulai & selesai otomatis berdasarkan inputan angka tadi (1 Juli - 30 Juni)
        $tanggal_mulai = $request->tahun_mulai . '-07-01';
        $tanggal_selesai = $request->tahun_selesai . '-06-30';

        // 5. Fitur Pengaman: Jika ceklis 'is_aktif' dicentang, matikan dulu tahun ajaran lain yang sedang aktif
        if ($request->has('is_aktif')) {
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => 0]);
        }

        // 6. Eksekusi Simpan ke database MySQL
        TahunAjaran::create([
            'nama'            => $request->nama,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'is_aktif'        => $request->has('is_aktif') ? 1 : 0,
        ]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        // 1. Gabungkan kembali data inputan kotak angka ganda menjadi format "2025/2026"
        $tahunAjaranGabung = $request->tahun_mulai . '/' . $request->tahun_selesai;
        
        // 2. Selipkan kembali ke inputan 'nama'
        $request->merge(['nama' => $tahunAjaranGabung]);

        // 3. Validasi anti-kembar (kecuali jika data itu milik ID tahun ajaran ini sendiri)
        $request->validate([
            'nama' => 'required|string|unique:tahun_ajarans,nama,' . $tahunAjaran->id,
        ], [
            'nama.unique' => 'Maaf, Tahun Ajaran ' . $tahunAjaranGabung . ' sudah digunakan oleh data lain. Silakan periksa kembali.',
        ]);

        // 4. Kalkulasi ulang otomatis tanggal periode (1 Juli - 30 Juni)
        $tanggal_mulai = $request->tahun_mulai . '-07-01';
        $tanggal_selesai = $request->tahun_selesai . '-06-30';

        // 5. Jika admin menceklis aktif, matikan status aktif data tahun ajaran lain
        if ($request->has('is_aktif')) {
            TahunAjaran::where('is_aktif', true)->where('id', '!=', $tahunAjaran->id)->update(['is_aktif' => 0]);
        }

        // 6. Jalankan pembaruan data ke database MySQL
        $tahunAjaran->update([
            'nama'            => $request->nama,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'is_aktif'        => $request->has('is_aktif') ? 1 : 0,
        ]);

        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diupdate!');
    }
    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('admin.tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus!');
    }
    // FUNGSI BARU: Menampilkan detail tahun ajaran agar tidak eror show()
    public function show($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('admin.tahun-ajaran.show', compact('tahunAjaran'));
    }
}