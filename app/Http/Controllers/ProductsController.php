<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductsController extends Controller
{
    public function show($slug)
    {
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
        $total= $cart->sum(function($item){
            return $item->product->price * $item->quantity;
        });
        $product=Product::where('slug',$slug)->firstOrFail();
        return view('front.products.show',[
           'product'=> $product,
           'cart'=>$cart,
            'total'=>$total,
        ]);
    }
}
