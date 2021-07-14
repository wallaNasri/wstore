<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

class CartsController extends Controller
{
    public function index()
    {
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
       $total= $cart->sum(function($item){
            return $item->product->price * $item->quantity;
        });
         return view('front.cart',[
             'cart'=>$cart,
             'total'=>$total,
         ]);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'quantity'=>'int|min:1',
        ]);
        $cart_id=App::make('cart_id');
        $pid=$request->post('product_id');
        $quantity=$request->post('quantity');

        $cart=Cart::where([
                   'product_id'=>$pid,
                   'cart_id'=>$cart_id,
        ])->first();

        if($cart){
            $cart->increment('quantity',$quantity);

        }
        else{

        $cart=Cart::create([
            'user_id'=>Auth::id(),
            'product_id'=>$pid,
            'cart_id'=>$cart_id,
            'quantity'=>$quantity,
        ]);
    }
        $product=Product::findOrFail($request->post('product_id'));
        return redirect()->route('checkout')
        ->with('status',"product  {$product->name} added to cart.");
    }

  
}
