<?php

namespace App\Http\Controllers\Api\Frontend;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use http\Env\Response;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::all()->pluck('name');
        return Response($categories);
    }
}
