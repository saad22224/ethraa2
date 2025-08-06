<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function tracking($mtcn)
    {
        $transaction = Transaction::where('transaction_code', $mtcn)->first();

        if(!$transaction) {
            return redirect()->back()->with('error', 'Transaction not found');
        }
        
        return view('track-result', compact('transaction'));
    }
}
