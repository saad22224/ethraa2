<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\money_receipts;

class Dashboard extends Controller
{
    public function index(){
        $userscount = User::where('type', 'user')->count();
        $totalbalances = User::where('type', 'user')->sum('balance');
        $totalwithdrawls = Transaction::where('status', 1)->sum('amount');
        $todaytransfers = Transaction::whereDate('created_at', today())->count();
        $moneyreceiptscount = money_receipts::count();
        return view('index' , [
            'userscount' => $userscount,
            'totalbalances' => $totalbalances,
            'totalwithdrawls' => $totalwithdrawls,
            'todaytransfers' => $todaytransfers,
            'moneyreceiptscount' => $moneyreceiptscount
        ]);
    }



}
