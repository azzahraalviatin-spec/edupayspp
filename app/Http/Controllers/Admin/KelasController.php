<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // PERBAIKAN: Wajib di-import untuk validasi data kembar gabungan

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->orderBy('nomor_kelas')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        // PERBAIKAN SAKTI: Memastikan tidak ada kombinasi tingkat + jurusan + nomor kelas yang kembar
        $request->validate([
            'tingkat'     => 'required|in:X,XI,XII',
            'jurusan'     => 'required|string|max:50',
            'nomor_kelas' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('tingkat', $request->tingkat)
                                 ->where('jurusan', $request->jurusan);
                })
            ],
            'wali_kelas'  => 'nullable|string|max:100',
        ], [
            // PERBAIKAN: Pesan error saat TAMBAH data sudah diganti jadi lebih sopan
            'nomor_kelas.unique' => 'Maaf, kelas ' . $request->tingkat . ' ' . $request->jurusan . ' ' . $request->nomor_kelas . ' sudah terdaftar di sistem. Silakan periksa kembali data Anda.',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit(Kelas $kelas)
    {
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        // PERBAIKAN SAKTI: Validasi anti-kembar saat update (kecuali milik data kelas ini sendiri)
        $request->validate([
            'tingkat'     => 'required|in:X,XI,XII',
            'jurusan'     => 'required|string|max:50',
            'nomor_kelas' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('kelas')->ignore($kelas->id)->where(function ($query) use ($request) {
                    return $query->where('tingkat', $request->tingkat)
                                 ->where('jurusan', $request->jurusan);
                })
            ],
            'wali_kelas'  => 'nullable|string|max:100',
        ], [
            // PERBAIKAN: Struktur kurung dibenarkan & Pesan error saat EDIT data sudah sopan
            'nomor_kelas.unique' => 'Maaf, perubahan ditolak karena kelas ' . $request->tingkat . ' ' . $request->jurusan . ' ' . $request->nomor_kelas . ' sudah digunakan oleh kelas lain.',
        ]);

        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function show($id)
    {
        $kelas = \App\Models\Kelas::findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }
}