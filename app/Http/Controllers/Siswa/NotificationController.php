<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifs = $user->notifications()->latest()->take(10)->get()->map(function($n) {
            return [
                'id'     => $n->id,
                'judul'  => $n->data['judul'],
                'pesan'  => $n->data['pesan'],
                'url'    => $n->data['url'],
                'icon'   => $n->data['icon'],
                'warna'  => $n->data['warna'],
                'dibaca' => !is_null($n->read_at),
                'waktu'  => $n->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifs'       => $notifs,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function baca($id)
    {
        $notif = Auth::user()->notifications()->findOrFail($id);
        $notif->markAsRead();
        return response()->json(['success' => true]);
    }

    public function bacaSemua()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}