<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Transfer;

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

            $transactions = Transaction::where("user_id", $user->id)->orderBy('created_at', 'desc')
                ->get();
        } else if ($type == "transfers") {
            $transactions = Transfer::where("sender_id", $user->id)
                ->orWhere("recipient_id", $user->id)->orderBy('created_at', 'desc')->get();
        }
        return response()->json($transactions);
    }
}
