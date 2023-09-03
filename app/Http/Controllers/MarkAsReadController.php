<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class MarkAsReadController extends Controller
{
    public function __invoke(Request $request, Notification $notification)
    {
        if($request->user()->id === $notification->owner_id){
            $notification->update(['is_read' => true]);
            return response()->json(['message' => 'Notification marked as read']);
        }
    }
}
