<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Illuminate\Http\Response;

class CityController extends Controller
{
    public function index()
    {
        $cities=DB::table('cities')->get('name');
        return Response($cities);
    }
}
