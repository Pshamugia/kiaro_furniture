<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    $products = Product::latest()->take(6)->get();
    return view('home', compact('products'));
})->name('home');

Route::view('/products', view: 'products')->name('products');
Route::view('/about', view: 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');

Route::get('/product/{product}', function (Product $product) {
    return view('product-full', compact('product'));
})->name('product.full');



//admin routes

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
});



Route::get('/login', [LoginController::class, 'show'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');