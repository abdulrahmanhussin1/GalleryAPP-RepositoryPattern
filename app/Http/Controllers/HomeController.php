<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\Album;
class HomeController extends Controller
{
    public function index()
    {

        $images = Image::where('user_id',auth()->user()->id)->get();
        return view('pages.home',compact('images'));
    }
}
