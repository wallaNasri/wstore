<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    
     public function __construct()
     {
         $this->middleware('auth:sanctum');
     }

    public function index()
    {
        $product= Product::all();
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::validateRules());
        $request->merge([
            'slug'=>Str::slug($request->name),
            'store_id'=>1,

        ]);

        $product=Product::create($request->all());
         $product->refresh();
         return response()->json($product,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::findOrFail($id);
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
        $request->validate(Product::validateRules());
        $product= Product::findOrFail($id);

       
        $product->update($request->all());
         return response()->json([
             'message'=>'Product Updated',
             'data'=>$product,
         ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'message'=>'Product Deleted',
            'data'=>$product,
        ],200);


    }
}
