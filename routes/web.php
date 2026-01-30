<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;



 


Route::get('/', function () {

    // NEW PRODUCTS (unchanged)
    $products = Product::latest()->take(3)->get();

    // Load categories with children + products
    $categories = Category::with([
        'children.products' => fn ($q) => $q->latest()->take(3),
        'products'          => fn ($q) => $q->latest()->take(3),
    ])
    ->whereNull('parent_id') // ONLY parent categories
    ->get();

    return view('home', compact('products', 'categories'));
})->name('home');
 
 
Route::view('/about', view: 'about')->name('about');

Route::view('/contact', 'contact')->name('contact');


//Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug?}', [ProductController::class, 'index'])
    ->name('products');


    
 


 


Route::get('/product/{slug}', function ($slug) {
    $slug = rawurldecode($slug);

    $product = Product::where('slug', $slug)->firstOrFail();

    return view('product-full', compact('product'));
})
->where('slug', '.*')
->name('product.full');



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

       Route::post(
    'product-images/{product_image}/delete',
    [ProductImageController::class, 'destroy']
)->name('product-images.destroy');

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