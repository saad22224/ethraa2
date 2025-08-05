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
        $country = $request->input('country');
        $receipts = money_receipts::where('country', $country)->get();
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
            $transaction_code = rand(10000000, 99999999);
            $user = auth()->user();
            DB::beginTransaction();
            if($user->balance < $request->amount) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }
            $user->balance -= $request->amount + $request->amount * 0.05;
            $user->transactions()->create([
                'transaction_number' => $transaction_numnber,
                'transaction_code' => $transaction_code,
                'addresse' => $request->addresse,
                'amount' => $request->amount,
            ]);
            DB::commit();
            return response()->json([
                'message' => 'Transaction successful',
                'user' => $user,
                'amount' => $request->amount,
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
