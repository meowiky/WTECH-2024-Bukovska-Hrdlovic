<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartPageController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'get'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/products', [ProductsController::class, 'showProductsPage'])->name('products');
Route::get('/filter-products', [ProductsController::class, 'filterProducts'])->name('filter-products');
Route::get('/categories/{category}/products', [ProductsController::class, 'showByCategory'])->name('category.products');

Route::get('/products/{id}', [ProductDetailController::class, 'show'])->name('product.show');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.dashboard');
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::post('/categories', [App\Http\Controllers\Admin\ProductController::class, 'addCategory'])->name('admin.categories.add');
    Route::delete('/categories/{id}', [App\Http\Controllers\Admin\ProductController::class, 'removeCategory'])->name('admin.categories.remove');
});

Route::get('/cartpage', [CartPageController::class, 'showCartPage'])->name('cartpage');
Route::delete('/cartpage', [CartPageController::class, 'remove'])->name('cartpage.remove');
Route::post('/cartpage/decrement', [CartPageController::class, 'decrementQuantity'])->name('cartpage.decrementQuantity');
Route::post('/cartpage/increment', [CartPageController::class, 'incrementQuantity'])->name('cartpage.incrementQuantity');

Route::get('/checkout', [CheckoutController::class, 'showCheckoutPage'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('process_checkout');


require __DIR__.'/auth.php';
