<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
class TicketController extends Controller
{
    public function send(Request $request) {
        $request->validate([
            'message' => 'required',
        ]);

        $user = auth('api')->user();
        if(!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $ticket = new Tiket();
        $ticket->user_id = $user->id;
        $ticket->message = $request->message;
        $ticket->save();

        return response()->json(['message' => 'تم الارسال بنجاح'], 200);
    }
}
