<?php

use App\Http\Controllers\client\AuthAdminController;
use App\Http\Controllers\client\AuthClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// LOGIN CLIENT (client)
Route::get('login', [AuthClientController::class, 'index'])->name('authClient.index');
Route::post('login', [AuthClientController::class, 'login'])->name('authClient.login');
Route::get('logout', [AuthClientController::class, 'logout'])->name('authClient.logout');
Route::get('register', [AuthClientController::class, 'register'])->name('authClient.register');
Route::post('signup', [AuthClientController::class, 'signup'])->name('authClient.signup');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AuthAdminController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthClientController::class, 'index']);
});
