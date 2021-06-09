<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class User extends Model 
{
    use HasFactory;
    protected $fillable=['name','email','password','birth_date','gender','phone'];

public function profile()
{
    return $this->hasOne(Profile::class,'user_id','id')->withDefoult([
        'first_name'=>'No Profle'
    ]);
}
}