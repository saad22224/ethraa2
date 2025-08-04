<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Dashboard extends Controller
{
    public function index(){
        return view('index');
    }



}
