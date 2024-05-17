<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resources([
        'suppliers' => SupplierController::class,
    ]);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.home.index');
    })->name('home');
    Route::resources([
        'products' => ProductController::class,
    ]);
    Route::prefix('cashiers')->name('cashiers.')->group(function () {
        Route::get('/', [UserController::class, 'getCashier'])->name('index');
        Route::post('cashiers', [UserController::class, 'store'])->name('store');
        Route::put('cashiers/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('cashiers/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
