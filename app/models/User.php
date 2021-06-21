<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    
use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * 

     */
    protected $fillable = [
        'name',
        'email',
        'password','birth_date','gender','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
{
    return $this->hasOne(Profile::class,'user_id','id')->withDefoult([
        'first_name'=>'No Profle'
    ]);
}

public function roles(){
    return $this->belongsToMany(Role::class,'role_user','user_id','role_id','id','id');
}

public function hasAbility($ability){
    foreach($this->roles as $role){
        if(in_array($ability,$role->abilities)){
            return true;
        }
    }
    return false;

}


}
