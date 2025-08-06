<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $PendingTransactions = Transaction::where('status', 0)->get();
        $completedTransactions = Transaction::where('status', 1)->get();
        $transactions = $PendingTransactions->merge($completedTransactions);
        return view('transactions', compact('transactions'));
    }

    public function changestatus($id)
    {
        $transaction = Transaction::find($id);
        $transaction->status = 1;
        $transaction->save();
        return redirect()->back();
    }
    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        return redirect()->back();
    }
}
