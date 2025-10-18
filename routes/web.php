<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\BrandController as ClientBrandController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController as ClientsProductController;
use App\Http\Controllers\Client\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Người dùng chưa đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
});

/*
|--------------------------------------------------------------------------
| Client Public Routes (Công khai - Không cần đăng nhập)
|--------------------------------------------------------------------------
*/
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');
    Route::get('/products', [ClientsProductController::class, 'all'])->name('product.index');
    Route::get('/product/{slug}', [ClientsProductController::class, 'show'])->name('product.show');
    Route::get('/search', [ClientsProductController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [ClientsProductController::class, 'category'])->name('product.category.index');

    Route::prefix('brands')->name('brand.')->group(function () {
        Route::get('{slug}', [ClientBrandController::class, 'index'])->name('index');
    });
});

/*
|--------------------------------------------------------------------------
| Client Authenticated Routes (Người dùng đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Auth actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile.index');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update/password', [AuthController::class, 'updatePassword'])->name('profile.update.password');

    // Reviews
    Route::get('/products/{slug}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/products/{slug}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/profile/reviews', [ReviewController::class, 'userReviews'])->name('profile.reviews');

    // Cart
    Route::prefix('client/cart')->name('client.cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
    });

    // Checkout
    Route::prefix('client/checkout')->name('client.checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');
        Route::post('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('remove-coupon');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');

        Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');
    });

    // Orders
    Route::prefix('client/my-orders')->name('client.my-orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Quản trị viên)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('brands', AdminBrandController::class);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    });
