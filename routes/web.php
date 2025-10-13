<?php

use App\Http\Controllers\Client\ProductController as ClientsProductController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\client\AuthAdminController;
use App\Http\Controllers\client\AuthClientController;
use App\Http\Controllers\Client\BrandController as ClientBrandController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeClientController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



/*
|--------------------------------------------------------------------------
| User UnAuthenticated Routes (Người dùng chưa đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
});


// Route::get('/products', [HomeController::class, 'products'])->name('products.list');
// Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('products.detail');
// Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
// Route::get('/brand/{slug}', [HomeController::class, 'brand'])->name('brand.show');


Route::prefix('client')->name('client.')->group(function () {
    // Route::get('/products', [ClientsProductController::class, 'products'])->name('product.index');
    Route::get('/products', [ClientsProductController::class, 'all'])->name('product.index');

    Route::get('/product/{slug}', [ClientsProductController::class, 'show'])->name('product.show');
    Route::get('/search', [ClientsProductController::class, 'search'])->name('search');
    Route::get('/category/{slug}', action: [ClientsProductController::class, 'category'])->name('product.category.index');

    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
    });



    Route::prefix('brands')->name('brand.')->group(function () {
        Route::get('{slug}', [ClientBrandController::class, 'index'])->name('index');
    });
});

/*
|--------------------------------------------------------------------------
| User Authenticated Routes (Người dùng đã đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {


    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
    });

    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('my-orders');
    Route::get('/my-orders/{order}', [CheckoutController::class, 'orderDetail'])->name('order-detail');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});
Route::get('/home', [HomeController::class, 'index'])->name('client.home');


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
