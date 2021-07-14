<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //  $this->authorize('view-any',Product::class);

        $products=Product::when($request->name,function($query,$value){
            $query->where('products.name','LIKE',"%$value%")
                  ->orWhere('products.description','LIKE',"%$value%");
        })
        ->when($request->categoy_id,function($query,$value){
            $query->where('products.categoy_id','=',$value);
        })
      
        ->with('category')
        ->latest()
        ->orderBy('name','ASC')
        ->paginate();



       // $products=Product::with('category')->latest()->paginate();
        return view('admin.products.index',[
            'products'=>$products,
            'categories'=>Category::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create',Product::class);

        return view('admin.products.create',[
            'product'=>new Product(),
            'categories'=>Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->authorize('create',Product::class);

      
        //validateRules function in the Product model 
        $request->validate(Product::validateRules());

       request()->merge([
           'slug'=>Str::slug($request->post('name')),
           'store_id'=>1,
       ]);
       $data=request()->all();
       if($request->hasFile('image')){
           $file=$request->file('image');
           $data['image']=$file->store('/image','uploads');
       }

       $product= Product::create($data);

       $tags=$request->post('tags');
       $tags=json_decode($tags);
       if(is_array($tags)&&count($tags)>0) {
           $product_tags=[];
           foreach($tags as $tag){
               $tag_name=$tag->value;
               $tagModel=Tag::firstOrCreate([
                   'name'=>$tag_name,
               ],[
                   'slug'=>Str::slug($tag_name),
               ]);
               $product_tags[]=$tagModel->id;
           }
           $product->tags()->sync($product_tags);
       }

       if($request->hasFile('gallery')){
        foreach($request->file('gallery') as $file ){
        
        $image_path=$file->store('/image','uploads');
        $product->images()->create([
            'image_path'=>$image_path
        ]);
    }
}

       return redirect()->route('products.index')
       ->with('success',"Product ($product->name)created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);
     //   $this->authorize('view',$product);

       return view('admin products.show',[
           'product'=>$product,
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
      //  $this->authorize('update',$product);

        $tags=$product->tags()->pluck('name')->toArray();
        
       return view('admin.products.edit',[
           'product'=>$product,
           'categories'=>Category::all(),
           'id'=>$id,
           'tags'=>implode(',',$tags),
       ]);
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
        $product=Product::findOrFail($id);
      //  $this->authorize('update',$product);

        request()->validate(Product::validateRules());

        $data=request()->all();
        $previous=false;
        if($request->hasFile('image')){
            $file=$request->file('image');
            $data['image']=$file->store('/image','uploads');
            $previous=$product->image;
        }
        $product->update($data);
        if($previous){
            Storage::disk('uploads')->delete($previous);
        }

        $tags=$request->post('tags');
        $tags=json_decode($tags);
        if(is_array($tags)&&count($tags)>0) {
            $product_tags=[];
            foreach($tags as $tag){
                $tag_name=$tag->value;
                $tagModel=Tag::firstOrCreate([
                    'name'=>$tag_name,
                ],[
                    'slug'=>Str::slug($tag_name),
                ]);
                $product_tags[]=$tagModel->id;
            }
            $product->tags()->sync($product_tags);
        }

          
        if($request->hasFile('gallery')){
            foreach($request->file('gallery') as $file ){
            
            $image_path=$file->store('/image','uploads');
            $product->images()->create([
                'image_path'=>$image_path
            ]);
        }
    }


        return redirect()->route('products.index')
       ->with('success',"Product ($product->name)updated!");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
      //  $this->authorize('delete',$product);

        $product->delete();
        if($product->image){
            Storage::disk('uploads')->delete($product->image);
        }

        return redirect()->route('products.index')
       ->with('success',"Product ($product->name)deleted!");

    }


}
