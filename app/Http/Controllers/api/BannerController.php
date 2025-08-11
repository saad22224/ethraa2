<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
class BannerController extends Controller
{
    public function Getbanners()
    {
        $banners = Banner::all();
        return response()->json($banners);
    }
}
