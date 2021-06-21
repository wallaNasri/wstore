<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
             'device_name'=>''
        ]);
        $user=User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password))
        {
            $device=$request->input('device_name',$request->userAgent());
            $token= $user->createToken($device,['*']);
            return response()->json([
                'token'=> $token->plainTextToken,

            ]);
        }
        return response()->json([
           'message'=>'invalid email and password'
        ],401);
    }

    public function logout(Request $request)
    {
        $user=Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message'=>'Token deleted'
         ]);
    }
}
