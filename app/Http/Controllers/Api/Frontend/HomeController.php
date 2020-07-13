<?php

namespace App\Http\Controllers\Api\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //
    public function index()
    {
        return view('frontend.home.index');
//        return response()->json(['result' => 'Access To Home'],200);
    }
}
