<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrderCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {     
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
        $total= $cart->sum(function($item){
             return $item->product->price * $item->quantity;
         });
          return view('front.checkout',[
              'cart'=>$cart,
              'total'=>$total,

          ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'=>'required|min:3|max:12',
            'last_name'=>'required|min:3|max:12',
             'email'=>'required|email',
             'phone'=>'required|regex:/^05[96][-]\d{7}$/',
             'address'=>'required',
             'city'=>'required',
             'country_code'=>'required',
             'postal_code'=>'required'
        ]);
        $cart=Cart::with('product')->where('cart_id',App::make('cart_id'))->get();
        $total= $cart->sum(function($item){
             return $item->product->price * $item->quantity;
         });

         if($cart->count()==0){
             redirect('/');
         }
      
        DB::beginTransaction();
        try{
              if($request->post('register')){
                  $user=$this->createUser($request);
              }
              $request->merge([
                'user_id'=>Auth::id(),
                'total'=>$total,
            ]);

        $order=Order::create($request->all());

        foreach($cart as $item)
        {
            $order->items()->create([
                'product_id'=>$item->product_id,
                'quantity'=>$item->quantity,
                'price'=>$item->product->price,
            ]);
        }

       $cart=Cart::where('cart_id',App::make('cart_id'))->delete();


        DB::commit();
        $user=User::where('type','=','admin')->first();
        $user->notify(new NewOrderCreatedNotification($order));
        return redirect('/')->with('status','Your order has been blaced');

    }
    catch(Throwable $e){
        DB::rollBack();
        return redirect()->back()->with('error',$e->getMessage())->withInput();

    }
    }
    
    protected function createUser(Request $request)
    {
        
            $user = new User();
            $user->name=$request->get('first_name').' '.$request->get('last_name');
            $user->email=$request->get('email');
            $user->phone=$request->get('phone');
            $user->password=Hash::make(Str::random(8));
            $user->gender='male';
            $user->birth_date=Carbon::now();
               $user->save();
               Auth::login($user);
               return $user;
    }
}
