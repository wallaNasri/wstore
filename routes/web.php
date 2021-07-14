<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\categoriesController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Hash;

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

Route::get('/', 'Admin\HomeController@index')->name('home');
Route::get('/contact', 'Admin\HomeController@contact')->name('contact');

Route::get('products/{slug}',[ProductsController::class,'show'])->name('product.show');

Route::get('carts',[CartsController::class,'index'])->name('cart');
Route::post('carts',[CartsController::class,'store']);

Route::get('checkout',[CheckoutController::class,'index'])->name('checkout');
Route::post('checkout',[CheckoutController::class,'store']);

Route::get('/p', function () {
    return Hash::make('$2y$10$xoozYUH0ukpqLAJ8UtRvVeS3p7C3lyfGx3wOqSGhcGVGYeipfsMdS');

});


Route::get('/Product', function () {
    return view('Product.index');
})->name('index3');

Route::group([
    'prefix'=>'admin/categories',
   // 'namespace'=>'Admin',
    'as'=>'admin.categories.',// for the name
    'middleware'=>['auth','password.confirm'],

],function(){
Route::get('/',[categoriesController::class,'index'])->name('index');
Route::get('/create',[categoriesController::class,'create'])->name('create');
Route::post('/store',[categoriesController::class,'store'])->name('store');
Route::get('/{id}/edit',[categoriesController::class,'edit'])->name('edit');
Route::put('/{id}',[categoriesController::class,'update'])->name('update');
Route::delete('/{id}',[categoriesController::class,'destroy'])->name('destroy');
});

Route::resource('admin/users','UserController')->middleware(['auth']);
Route::resource('admin/products','Admin\productsController')->middleware(['auth','user.type:admin,user']);
Route::resource('roles','Admin\RolesController');






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



