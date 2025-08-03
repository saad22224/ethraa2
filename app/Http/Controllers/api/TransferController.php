<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $user_identifier = $request->user_identifier;
        $amount = $request->amount;
        $sender = auth()->user();
        $sender->balance -= $amount;
        $sender->save();
        $recipient = User::where('user_identifier', $user_identifier)->first();
        $recipient->balance += $amount;
        $recipient->save();
        return response()->json(['message' => 'Transfer successful']);
    }
}
