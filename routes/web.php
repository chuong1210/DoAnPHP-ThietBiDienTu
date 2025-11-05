<?php

// Import các Controller
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\BrandController as ClientBrandController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ChatController as ClientChatController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsletterController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController as ClientsProductController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Client\SupportController;
use App\Http\Controllers\Client\VnpayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FaqController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ghi chú: Route gốc đang trỏ đến trang login.
// Nếu muốn trỏ đến trang chủ, hãy thay đổi thành:
// Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect()->route('client.home.index'); // Tốt hơn là redirect đến trang chủ
})->name('root');

// Tạo các route cho xác thực (login, register, forgot password, email verification)
// Auth::routes(['verify' => true]);
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])->name('verification.verify'); // <-- Chỉ giữ lại 'signed'

// Route này vẫn cần 'auth' để biết user nào đang yêu cầu gửi lại email
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');
/*
|--------------------------------------------------------------------------
| Guest Routes (Chỉ dành cho khách)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Laravel đã tạo route này, nhưng định nghĩa lại để custom controller
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

/*
|--------------------------------------------------------------------------
| Client Public Routes (Công khai cho mọi người)
|--------------------------------------------------------------------------
*/
Route::name('client.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    Route::prefix('products')->name('product.')->group(function () {
        Route::get('/all', [ClientsProductController::class, 'all'])->name('all');
        Route::get('/', [ClientsProductController::class, 'index'])->name('index');
        Route::get('/{slug}', [ClientsProductController::class, 'show'])->name('show');
    });

    Route::get('/search', [ClientsProductController::class, 'search'])->name('search');
    Route::get('/category/{slug}', [ClientsProductController::class, 'category'])->name('product.category.index');
    Route::get('/brands/{slug}', [ClientBrandController::class, 'index'])->name('brand.index');
});

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/support', [SupportController::class, 'index'])->name('client.support.index');
Route::post('/support/contact', [SupportController::class, 'contact'])->name('client.support.contact');

// VNPay Routes (Không cần auth, vì VNPay server sẽ gọi vào)
Route::get('/vnpay/callback', [VnpayController::class, 'callback'])->name('vnpay.callback');
Route::get('/vnpay/ipn', [VnpayController::class, 'ipn'])->name('vnpay.ipn');

/*
|--------------------------------------------------------------------------
| Client Authenticated Routes (Yêu cầu đăng nhập)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // === CÁC ROUTE CHỈ CẦN ĐĂNG NHẬP ===
    Route::prefix('client')->name('client.')->group(function () {
        // Cart Routes
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
            Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
            Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
        });
    });


    // Chat Widget Routes
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/room', [ClientChatController::class, 'getRoom'])->name('room');
        Route::get('/unread-count', [ClientChatController::class, 'unreadCount'])->name('unread-count');
        Route::post('/rooms/{room}/messages', [ClientChatController::class, 'sendMessage'])->name('send');
        Route::post('/rooms/{room}/read', [ClientChatController::class, 'markAsRead'])->name('mark-read');
    });


    // === CÁC ROUTE YÊU CẦU ĐÃ XÁC THỰC EMAIL (quan trọng) ===
    Route::middleware('verified')->group(function () {
        Route::prefix('client')->name('client.')->group(function () {
            // Profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile.index');
            Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
            Route::post('/profile/update/password', [AuthController::class, 'updatePassword'])->name('profile.update.password');

            // Reviews
            Route::get('/products/{slug}/review/create', [ReviewController::class, 'create'])->name('reviews.create');

            Route::post('/products/{slug}/review', [ReviewController::class, 'store'])->name('reviews.store');
            Route::get('/profile/reviews', [ReviewController::class, 'userReviews'])->name('profile.reviews');

            // Checkout
            Route::prefix('checkout')->name('checkout.')->group(function () {
                Route::get('/', [CheckoutController::class, 'index'])->name('index');
                Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply-coupon');
                Route::post('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('remove-coupon');
                Route::post('/process', [CheckoutController::class, 'process'])->name('process');
                Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
            });

            // My Orders
            Route::prefix('my-orders')->name('my-orders.')->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('index');
                Route::get('/{id}', [OrderController::class, 'show'])->name('show');
                Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
            });
        });
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Yêu cầu đăng nhập và là admin)
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Admin Routes (Quản trị viên)
|--------------------------------------------------------------------------
|
| Các route này yêu cầu người dùng phải đăng nhập, đã xác thực email,
| và có vai trò là 'admin'.
|
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // --- Quản lý tài nguyên (Resource Controllers) ---
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('brands', AdminBrandController::class);
        Route::resource('banners', BannerController::class);
        // Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy', 'show']);
        Route::resource('reviews', AdminReviewController::class);
        Route::resource('users', UserController::class);
        // Resource
        Route::get('orders/{order}/invoice', [AdminOrderController::class, 'showInvoice'])->name('orders.invoice');


        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::resource('banners', BannerController::class);
        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::get('reviews/{id}', [AdminReviewController::class, 'show'])->name('reviews.show');
        Route::patch('reviews/{id}/status', [AdminReviewController::class, 'updateStatus'])->name('reviews.updateStatus');
        Route::delete('reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');


        // Quản lý đơn hàng (Orders)

        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // Route này cho phép form trong trang show gửi yêu cầu PUT đến controller
        Route::put('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        // --- Các Nhóm Route Chức Năng Riêng ---

        // Quản lý liên hệ (Contact)
        Route::prefix('contact')->name('contact.')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('index');
            Route::get('/{id}', [ContactController::class, 'show'])->name('show');
            Route::post('/{id}/send', [ContactController::class, 'sendEmail'])->name('send');
        });

        // Quản lý câu hỏi thường gặp (FAQ)
        Route::prefix('faqs')->name('faqs.')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('index');
            Route::get('/create', [FaqController::class, 'create'])->name('create');
            Route::post('/', [FaqController::class, 'store'])->name('store');
            Route::get('/{faq}', [FaqController::class, 'show'])->name('show');
            Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit');
            Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
            Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');
            Route::get('/category/{category}', [FaqController::class, 'showByCategory'])->name('category');
        });

        // Quản lý Chat
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [AdminChatController::class, 'index'])->name('index');
            Route::get('/rooms/{room}/messages', [AdminChatController::class, 'getMessages'])->name('messages');
            Route::post('/rooms/{room}/messages', [AdminChatController::class, 'sendMessage'])->name('send');
            Route::post('/rooms/{room}/close', [AdminChatController::class, 'closeRoom'])->name('close');
            Route::post('/rooms/{room}/open', [AdminChatController::class, 'openRoom'])->name('open');
        });
    });
