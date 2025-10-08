<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($notificationId)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cari notifikasi milik pengguna yang sedang login
        $notification = Auth::user()->notifications()->find($notificationId);

        // Jika notifikasi ditemukan
        if ($notification) {
            // Tandai sebagai sudah dibaca
            $notification->markAsRead();

            // Ambil URL tujuan dari data notifikasi, jika tidak ada, arahkan ke dashboard
            $redirectUrl = $notification->data['url'] ?? '/dashboard';

            return redirect($redirectUrl);
        }

        // Jika notifikasi tidak ditemukan, kembali ke halaman sebelumnya
        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }
}
