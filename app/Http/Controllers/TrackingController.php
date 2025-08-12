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

    public function tracking(Request $request)
    {
        $mtcn = $request->input('mtcn');
        $transaction = Transaction::where('transaction_code', $mtcn)->first();

        if(!$transaction) {
            return redirect()->back()->with('error', 'رقم الحوالة غير صحيح برجاء ادخال رقم اخر');
        }
        
        return view('track-result', compact('transaction'));
    }
}
