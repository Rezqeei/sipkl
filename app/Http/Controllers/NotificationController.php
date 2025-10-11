<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($notificationId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $notification = Auth::user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();

            $redirectUrl = $notification->data['url'] ?? '/dashboard';

            return redirect($redirectUrl);
        }

        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }
}
