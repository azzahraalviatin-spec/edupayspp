<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingSpp;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SettingSppController extends Controller
{
    public function index()
    {
        $settings = SettingSpp::with(['kelas', 'tahunAjaran'])->get();
        return view('admin.setting-spp.index', compact('settings'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->get();
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        return view('admin.setting-spp.create', compact('kelas', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
     $request->validate([
    'tahun_ajaran_id' => 'required',
    'kelas_id'        => 'required',
    'nominal'         => 'required|numeric|min:0', // Pastikan pake numeric, bukan digits
]);
        SettingSpp::updateOrCreate(
            ['kelas_id' => $request->kelas_id, 'tahun_ajaran_id' => $request->tahun_ajaran_id],
            ['nominal' => $request->nominal]
        );

        return redirect()->route('admin.setting-spp.index')->with('success', 'Setting SPP berhasil disimpan!');
    }

    public function edit(SettingSpp $settingSpp)
    {
        $kelas = Kelas::orderBy('tingkat')->orderBy('jurusan')->get();
        $tahunAjarans = TahunAjaran::orderBy('nama', 'desc')->get();
        return view('admin.setting-spp.edit', compact('settingSpp', 'kelas', 'tahunAjarans'));
    }

    public function update(Request $request, SettingSpp $settingSpp)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
        ]);

        $settingSpp->update(['nominal' => $request->nominal]);

        return redirect()->route('admin.setting-spp.index')->with('success', 'Setting SPP berhasil diupdate!');
    }

    public function destroy(SettingSpp $settingSpp)
    {
        $settingSpp->delete();
        return redirect()->route('admin.setting-spp.index')->with('success', 'Setting SPP berhasil dihapus!');
    }
    public function show(SettingSpp $settingSpp)
{
    // Kita load relasi kelas dan tahun ajaran agar datanya muncul di blade
    $settingSpp->load(['kelas', 'tahunAjaran']);
    
    return view('admin.setting-spp.show', compact('settingSpp'));
}
}
