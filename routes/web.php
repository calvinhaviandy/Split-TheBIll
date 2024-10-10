<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\CategoryController;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');

Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])->name('categories-detail');

Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');

Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

/* Route::post('/checkout/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('midtrans-callback'); */

Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');

Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])->name('success');

Route::get('/faq', function () {
    return view('pages/faq');
})->name('faq');

Route::get('/dashboard/category', [App\Http\Controllers\DashboardController::class, 'category'])->name('dashboard-category');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');

    Route::put('/cart/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart-update');

    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart-delete');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout-success');

    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])->name('dashboard-product');

    Route::get('/dashboard/products/create', [App\Http\Controllers\DashboardProductController::class, 'create'])->name('dashboard-product-create');

    Route::post('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'store'])->name('dashboard-product-store');

    Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])->name('dashboard-product-detail');

    Route::post('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'update'])->name('dashboard-product-update');

    Route::post('/dashboard/products/gallery/upload', [App\Http\Controllers\DashboardProductController::class, 'uploadGallery'])->name('dashboard-product-gallery-upload');

    Route::get('/dashboard/products/gallery/delete/{id}', [App\Http\Controllers\DashboardProductController::class, 'deleteGallery'])->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transactions', [App\Http\Controllers\DashboardTransactionController::class, 'index'])->name('dashboard-transaction');

    Route::get('/dashboard/transactions-buy/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsBuy'])->name('dashboard-transaction-details-buy');

    Route::get('/dashboard/transactions-sell/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'detailsSell'])->name('dashboard-transaction-details-sell');

    Route::post('/dashboard/transactions/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])->name('dashboard-transaction-update');

    Route::get('/dashboard/settings', [App\Http\Controllers\DashboardSettingController::class, 'store'])->name('dashboard-settings-store');

    Route::put('/dashboard/settings', [App\Http\Controllers\DashboardSettingController::class, 'storeUpdate'])->name('dashboard-settings-store-update');

    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])->name('dashboard-settings-account');

    /* Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect'); */

    Route::put('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardSettingController::class, 'update'])->name('dashboard-settings-redirect');

    Route::post('/review/{id}', [App\Http\Controllers\ReviewController::class, 'store'])->name('review-add');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    
    Route::post('/wishlist/{id}', [WishlistController::class, 'addWishlist'])->name('wishlist-add');
});

/* ->middleware(['auth', 'admin']) */
Route::prefix('admin')
    /* ->namespace('Admin') */
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin-dashboard');

        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);

        Route::resource('user', App\Http\Controllers\Admin\UserController::class);

        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);

        Route::resource('product-gallery', App\Http\Controllers\Admin\ProductGalleryController::class);

        /* Route::resource('category', [App\Http\Controllers\Admin\CategoryController::class, 'index']); */

        /* Route::get('/', 'DashboardController@index')->name('admin-dashboard'); */
    });

Auth::routes();

Route::get('/{slugSeller}', [App\Http\Controllers\HomeController::class, 'storeProfile'])->name('store-profile');