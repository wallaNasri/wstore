<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'=>'required|regex:/^05[96][-]\d{7}$/|unique:users,phone',
            'gender'=>'required|in:female,male',
            'birth_date'=>'date',
        
        ]);


        $user = new User();
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $user->phone=$request->get('phone');
        $user->password=Hash::make($request->get('password'));
        $user->gender=$request->get('gender');
        $user->birth_date=$request->get('birth_date');

        $user->save();        

        event(new Registered($user));

      Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
