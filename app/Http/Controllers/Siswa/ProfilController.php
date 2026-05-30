<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        return view('siswa.profil', compact('user', 'siswa'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'no_hp_ortu' => 'nullable|string|max:20',
            'nama_ortu'  => 'nullable|string|max:100',
        ]);

        $user->siswa->update([
            'no_hp_ortu' => $request->no_hp_ortu,
            'nama_ortu'  => $request->nama_ortu,
        ]);

        return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diupdate!');
    }
}