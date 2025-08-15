<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\money_receipts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{



    public function getMoneyReceiptsByCountry(Request $request)
    {
        $user = auth()->user();
        if(!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $country = $request->input('country');
        $receipts = money_receipts::where('country', $country)->get();
        if(!$receipts) {
            return response()->json(['error' => 'No receipts found'], 404);
        }
        return response()->json($receipts);
    }

    public function transaction(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required',
                'addresse' => 'required',
            ]);
            $transaction_numnber = rand(100000, 999999);
            $transaction_code = rand(1000000000, 9999999999);
            $user = auth()->user();
            DB::beginTransaction();
            if($user->balance < $request->amount) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
            $amountaftertaxs =  $request->amount - $request->amount * 0.05;
            $user->balance -= $request->amount;
            $user->save();

            $user->transactions()->create([
                'transaction_number' => $transaction_numnber,
                'transaction_code' => $transaction_code,
                'addresse' => $request->addresse,
                'amount' => $amountaftertaxs,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Transaction successful',
                'user' => $user,
                'amount' =>  "$amountaftertaxs",
                'addresse' => $request->addresse,
                'transaction_number' => $transaction_numnber,
                'transaction_code' => $transaction_code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}