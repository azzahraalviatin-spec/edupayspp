<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function baca($id)
    {
        $notif = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notif) {
            $notif->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function bacaSemua()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}