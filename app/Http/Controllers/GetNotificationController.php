<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class GetNotificationController extends Controller
{
   public function __invoke(Request $request)
   {
       $user = $request->user();
       $notifications = Notification::where('owner_id', $user->id)->get();
       return NotificationResource::collection($notifications);
   }
}
