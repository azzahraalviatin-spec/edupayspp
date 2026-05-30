<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    // 1. Tampilan Halaman Utama (Tabel List)
    public function index()
    {
        $metode = MetodePembayaran::all();
        return view('admin.pembayaran.index', compact('metode'));
    }

    // 2. Tampilan Halaman Form Tambah Data
    public function create()
    {
        return view('admin.pembayaran.create');
    }

    // 3. Proses Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
        ]);

        MetodePembayaran::create([
            'nama'        => $request->nama,
            'jenis'       => 'tunai', // Tetap diset aman untuk ENUM MySQL kamu wee
            'no_rekening' => $request->no_rekening,
            'atas_nama'   => $request->atas_nama,
            'is_aktif'    => $request->has('is_aktif'),
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    // 4. Tampilan Halaman Detail Data
    public function show($id)
    {
        $metode = MetodePembayaran::findOrFail($id);
        return view('admin.pembayaran.detail', compact('metode'));
    }

    // 5. Tampilan Halaman Form Edit Data
    public function edit($id)
    {
        $metode = MetodePembayaran::findOrFail($id);
        return view('admin.pembayaran.edit', compact('metode'));
    }

    // 6. Proses Update Data (CUMA ADA SATU DI SINI WEE, GA BAKAL DUPLIKAT LAGI)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
        ]);

        $metode = MetodePembayaran::findOrFail($id);
        $metode->update([
            'nama'        => $request->nama,
            'no_rekening' => $request->no_rekening,
            'atas_nama'   => $request->atas_nama,
            'is_aktif'    => $request->has('is_aktif'),
        ]);

        return redirect()->route('admin.pembayaran.index')->with('success', 'Metode pembayaran berhasil diubah!');
    }

    // 7. Proses Hapus Data
    public function destroy($id)
    {
        MetodePembayaran::findOrFail($id)->delete();
        return redirect()->route('admin.pembayaran.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}