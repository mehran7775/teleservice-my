<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class CityController extends Controller
{
    public function index()
    {
        $cities=DB::table('cities')->get('name');
        return response()->json($cities);
    }
}
