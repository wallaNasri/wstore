<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable=['product_id','image_path'];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function getImageUrlAttribute(){
        
        
            return asset('uploads/'.$this->image_path);
       
    }
}
