<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function index()
    {
        $latest=Product::latest()->take(10)->get();
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
        $total= $cart->sum(function($item){
            return $item->product->price * $item->quantity;
        });

        return view('home',[
            'latest'=>$latest,
            'cart'=>$cart,
            'total'=>$total,
        ]);

    }

    public function contact()
    {
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
        $total= $cart->sum(function($item){
            return $item->product->price * $item->quantity;
        });
        return view('front.contact',[
            'cart'=>$cart,
            'total'=>$total,

        ]);
    }
}
