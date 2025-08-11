<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banners', compact('banners'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $banner = new Banner();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $banner->image =   $file->storeAs('banners', $filename);
        }
        $banner->title = $request->title;
        $banner->link = $request->link;
        $banner->save();
        return redirect()->route('banners')->with('success', 'Banner added successfully');
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('banners')->with('success', 'Banner deleted successfully');
    }
}
