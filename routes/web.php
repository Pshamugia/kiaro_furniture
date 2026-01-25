<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Models\ProductImage;


Route::get('/', function () {
    $products = Product::latest()->take(6)->get();
    return view('home', compact('products'));
})->name('home');

 
 
Route::view('/about', view: 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');


Route::get('/products', [ProductController::class, 'index'])->name('products');
 
Route::get('/product/{product}', function (Product $product) {
    return view('product-full', compact('product'));
})->name('product.full');


Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');
 
Route::post('/order/send', [OrderController::class, 'send'])
    ->name('order.send');


    Route::get('/search', [SearchController::class, 'index'])
    ->name('search');


//admin routes

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

Route::resource('products', AdminProductController::class);
        Route::resource('categories', CategoryController::class);
});



Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


    Route::get('/fix-image-paths', function () {
    $fixed = 0;

    ProductImage::where('image', 'like', 'storage/%')->each(function ($img) use (&$fixed) {
        $img->image = str_replace('storage/', '', $img->image);
        $img->save();
        $fixed++;
    });

    return "Fixed {$fixed} images";
});