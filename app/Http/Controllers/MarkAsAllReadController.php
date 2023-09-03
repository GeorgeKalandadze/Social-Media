<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkAsAllReadController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->notifications->each(function ($notification) {
            if (!$notification->is_read) {
                $notification->update(['is_read' => true]);
            }
        });

        return response()->json(['message' => 'All notifications marked as read']);
    }
}
