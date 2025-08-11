<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('type', 'user')->get();
        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'balance' => $request->balance,
        ]);

        return redirect()->route('users')->with('success', 'User created successfully');
    }
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,' . $id,
        // ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        // $user->email = $request->email;

        // فقط حدث الباسورد لو مبعوتة
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users')->with('success', 'User updated successfully');
    }

    public function addbalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        $user = User::findOrFail($id);
        $user->balance += $request->amount;
        $user->save();
        return redirect()->route('users')->with('success', 'Balance added successfully');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users')->with('success', 'User deleted successfully');
    }


    public function changestatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status; // 0 أو 1
        $user->save();

        return response()->json([
            'message' => $user->status
                ? 'تم ترقية المستخدم بنجاح'
                : 'تم إلغاء ترقية المستخدم'
        ]);
    }
}
