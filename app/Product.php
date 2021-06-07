<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //في حالة استخدام method create في store
    protected $fillable=['name','category_id','description','price','sale_price','quantity','image',
'status','slug','store_id'];


    protected $perPage=10;
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function getImageUrlAttribute(){
        
        if($this->image)
        {
            if(strpos($this->image,'http')===0){
                return $this->image;
            }
            return asset('uploads/'.$this->image);
        }
        return asset('images/defoult.jpg');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,
        'product_tag',
        'product_id',
        'tag_id',
        'id',
        'id'
    );
    }

    public function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    public static function validateRules()
    {
        return[
            'name'=>'required|string|max:255|min:3',
            'category_id'=>'required|exists:categories,id',
            'image'=>'image',
            'price'=>'numeric|min:0',
            'sale_price'=>['numeric','min:0',function($attr,$value,$fail){
                $price=request()->input('price');
                if($value>=$price){
                    $fail(':attribute must be less than regular price');
                }

            }]

        ];
       

    }
  
}
