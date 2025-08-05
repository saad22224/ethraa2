<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credintails = $request->only('email', 'password');
        if (auth()->attempt($credintails)) {
            if (auth()->user()->type != 'admin') {
                return redirect()->back()->with('error', 'You are not admin');
            }
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('error', 'Invalid credentials');



        // dd($request->all());
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/admin');
    }
}
