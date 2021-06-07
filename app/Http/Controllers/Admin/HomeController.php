<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latest=Product::latest()->take(10)->get();
        return view('home',[
            'latest'=>$latest,
        ]);

    }
}
