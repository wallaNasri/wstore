<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required|max:255|min:3|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|regex:/^05[96][-]\d{7}$/|unique:users,phone',
            'password'=>'required|min:9|max:15',
            'gender'=>'required|in:Female,Male',
            'birth_date'=>['date',
            function($attribute,$value,$fail){
                if(Carbon::now()->addYear(-14)>=date(2007-00-00)){
                    $fail('The age must be less than 14');
                } }]
        ] );



        $user = new User();
        $user->name=$request->get('name');
        $user->email=$request->get('email');
        $user->phone=$request->get('phone');
        $user->password=Hash::make($request->get('password'));
        $user->gender=$request->get('gender');
        $user->birth_date=$request->get('birth_date');

        $user->save();

        return redirect(route('users.create'))->with('success','user add successfuly');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
