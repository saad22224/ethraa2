<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuth extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credintails = $request->only('email','password');
        if(auth()->attempt($credintails)){
            if(auth()->user()->type != 'admin'){
                return redirect()->back()->with('error','You are not admin');
            }
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('error','Invalid credentials');



        // dd($request->all());
    }
}
