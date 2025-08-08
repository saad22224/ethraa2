<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseMail;
use App\Models\User;
class TicketController extends Controller
{
    public function index()
    {
        $tickets = Tiket::all();
        return view('tickets', compact('tickets'));
    }

    public function delete($id)
    {
        $ticket = Tiket::find($id);
        $ticket->delete();
        return redirect()->back();
    }

    public function response(Request $request)
    {
        $request->validate([
            'response' => 'required',
            'email' => 'required|exists:users,email',
        ]);
        $user = User::where('email', $request->email)->first();
        Mail::to($request->email)->send(new ResponseMail($request->response, $user->name));
        return redirect()->back();
    }
}
