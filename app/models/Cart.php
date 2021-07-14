<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable=['cart_id','product_id','user_id','quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault();
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}
