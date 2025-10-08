<?php

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
