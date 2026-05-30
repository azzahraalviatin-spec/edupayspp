<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    // FUNGSI UTAMA: Menampilkan halaman profil admin yang sedang login
    public function index()
    {
        $user = Auth::user(); // Mengambil data admin yang lagi buka aplikasi
        return view('admin.profil.index', compact('user'));
    }
}