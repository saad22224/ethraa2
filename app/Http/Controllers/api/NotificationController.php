<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function GetUserNotifications(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $notifications = $user->notifications()->get();
        return response()->json($notifications);
    }


    public function GetUserHistory(Request $request)
    {
        $user = auth()->user();
        $type = $request->type;
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($type == "transactions") {

            $history = $user->transactions()->get();
        } else if ($type == "transfers") {
            $sent = $user->transfers()->where('sender_id', $user->id)->get();
            $received = $user->transfers()->where('recipient_id', $user->id)->get();
            // $history = shuffle($received , $sent);

            return response()->json([
                'sent' => $sent,
                'received' => $received
            ]);
        }
        return response()->json($history);
    }
}
