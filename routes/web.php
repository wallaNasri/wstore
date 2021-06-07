<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Admin\HomeController@index');
    




Route::get('/Product', function () {
    return view('Product.index');
})->name('index3');

Route::group([
    'prefix'=>'admin/categories',
   // 'namespace'=>'Admin',
    'as'=>'admin.categories.',// for the name

],function(){
Route::get('/',[categoriesController::class,'index'])->name('index');
Route::get('/create',[categoriesController::class,'create'])->name('create');
Route::post('/store',[categoriesController::class,'store'])->name('store');
Route::get('/{id}/edit',[categoriesController::class,'edit'])->name('edit');
Route::put('/{id}',[categoriesController::class,'update'])->name('update');
Route::delete('/{id}',[categoriesController::class,'destroy'])->name('destroy');
});

Route::resource('admin/users','UserController');
Route::resource('admin/products','Admin\productsController');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



