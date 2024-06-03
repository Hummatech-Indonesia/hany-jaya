<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductUnitController;
use App\Http\Controllers\Admin\PurchasesController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupplierProductController;
use App\Http\Controllers\Admin\UnitController;
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


Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('cashier', function () {
    // dd("Aa");
    return view('dashboard.selling.index');
})->name('cashier');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard.home.index');
    })->name('home');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('supplier-products/{supplier?}', [SupplierProductController::class, 'index'])->name('supplier.product.index');
        Route::get('product-units/{product?}', [ProductUnitController::class, 'index'])->name('product.unit.index');
        Route::get('units-ajax', [UnitController::class, 'get'])->name('units.get');
        Route::resources([
            'products' => ProductController::class,
            'suppliers' => SupplierController::class,
            'categories' => CategoryController::class,
            'units' => UnitController::class,
        ]);
        Route::prefix('cashiers')->name('cashiers.')->group(function () {
            Route::get('/', [UserController::class, 'getCashier'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('purchases')->name('purchases.')->group(function () {
            Route::get('/', [PurchasesController::class, 'create'])->name('create');
            Route::post('/', [PurchasesController::class, 'store'])->name('store');
            Route::get('history', [PurchasesController::class, 'history'])->name('index');
        });
    });
});
