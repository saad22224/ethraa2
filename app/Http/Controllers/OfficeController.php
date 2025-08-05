<?php

namespace App\Http\Controllers;

use App\Models\money_receipts;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $money_receipts = money_receipts::all();
        return view('office', compact('money_receipts'));
    }

    public function update(Request $request , $id)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'addresse' => 'required',
            'phone' => 'required',
        ]);

        $money_receipts = money_receipts::find($id);
        $money_receipts->name = $request->name;
        $money_receipts->country = $request->country;
        $money_receipts->city = $request->city;
        $money_receipts->addresse = $request->addresse;
        $money_receipts->phone = $request->phone;
        $money_receipts->save();
        return redirect()->route('offices')->with('success', 'Office updated successfully');
    }

    public function store (Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'city' => 'required',
            'addresse' => 'required',
            'phone' => 'required',
        ]);

        $money_receipts = new money_receipts();
        $money_receipts->name = $request->name;
        $money_receipts->country = $request->country;
        $money_receipts->city = $request->city;
        $money_receipts->addresse = $request->addresse;
        $money_receipts->phone = $request->phone;
        $money_receipts->save();
        return redirect()->route('offices')->with('success', 'Office added successfully');
    }

    public function delete($id)
    {
        $money_receipts = money_receipts::find($id);
        $money_receipts->delete();
        return redirect()->route('offices')->with('success', 'Office deleted successfully');
    }
}
