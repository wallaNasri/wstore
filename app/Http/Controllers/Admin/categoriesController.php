<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Rules\WordFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class categoriesController extends Controller
{
    public function index(Request $request)
    {
       // $this->authorize('view-any',Category::class);

        $categories=Category::when($request->name,function($query,$value){
            $query->where('categories.name','LIKE',"%$value%")
                  ->orWhere('categories.description','LIKE',"%$value%");
        })
        ->when($request->parent_id,function($query,$value){
            $query->where('categories.parent_id','=',$value);
        })
       /* ->leftJoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
        //Eager loading
        ->with('parent')
        ->get();

        $parents=Category::orderBy('name','asc')->get();
         return view('admin.categories.index',[
             'categories'=>$categories,
             'parents'=>$parents,
             ]);
    }
public function create()
{
  //  $this->authorize('create',Category::class);

    $parents=Category::orderBy('name','asc')->get();
    return view('admin.categories.create',['parents'=>$parents]);
}

public function store(Request $request)
{
   // $this->authorize('create',Category::class);


    $this->validateRequest($request);

    $category =new Category();
    $category->name=$request->name;
    $category->description=$request->description;
    $category->status=$request->status;
    $category->slug=Str::slug($request->name);
    $category->parent_id=$request->post('parent_id');

    $category->save();

    return redirect(route('admin.categories.index'))->with('success','category add successfuly');


}
public function edit($id){

    // نستخدم where حتى لا يظهر الكاتيجوري الحالي(الذي نريد عمل تعديل عليه) ضمن قائمة البيرنت
    $parents=Category::where('id','<>',$id)
    ->orderBy('name','asc')
    ->get();
    $category=Category::findOrFail($id);
  //  $this->authorize('update',$category);

   // if( $category==null){
    //    abort(404);

   // }
    return view('admin.categories.edit',[
        'id'=>$id,
        'parents'=>$parents,
        'category'=>$category,
    ]);

}
public function update(Request $request,$id){
    $category=Category::findOrFail($id);
   // $this->authorize('update',$category);


    $this->validateRequest($request,$id);


    $category->name=$request->name;
    $category->description=$request->description;
    $category->status=$request->status;
    $category->slug=Str::slug($request->name);
    $category->parent_id=$request->post('parent_id');

    $category->save();

    return redirect()
    ->route('admin.categories.index')
    ->with('success','category updated successfuly');

}

public function destroy($id)
{
    $category=Category::findOrFail($id);
   // $this->authorize('delete',$category);
    $category->delete(); 
     
      return redirect()
    ->route('admin.categories.index')
    ->with('success','category deleted');
}
protected function validateRequest(Request $request,$id=0)
{

    $validator=Validator::make(

        $request->all(),[
            'name'=>"required|max:255|min:3|unique:categories,name,$id",
            'description'=>
            ['nullable',
            'min:5',
           /* function($attribute,$value,$fail){
                if(stripos($value,'laravel')!==false){
                    $fail('You can not use the word "laravel"');
                }

            }*/
            new WordFilter(['php','laravel']),
        ],
            'parent_id'=>[
                'nullable',
                'exists:categories,id'
            ],
            'image'=>[
                'nullable',
                'image',
            ],
            'status'=>'required|in:active,inactive'

        ]

      );
      $a=$validator->fails();
      $b=$validator->failed();
      $errors=$validator->errors();

      $b=$validator->validate();
}


}
