<?php

use App\Http\Controllers\AdjustmentController;
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
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Cashier\SellingController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryPayDebtController;
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


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::patch('profile-change-password', [ProfileController::class, 'changePassword'])->name('profile.change.password');
    Route::get('admin/update-profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::patch('admin/update-profile', [ProfileController::class, 'update'])->name('admin.update.profile');
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('supplier-products/{supplier?}', [SupplierProductController::class, 'index'])->name('supplier.product.index');
        Route::get('product-units/{product?}', [ProductUnitController::class, 'index'])->name('product.unit.index');
        Route::get('units-ajax', [UnitController::class, 'get'])->name('units.get');

        Route::post('category-ajax', [CategoryController::class, 'storeAjax'])->name('category.store.ajax');
        Route::get('getCategoryAjax', [CategoryController::class, 'getCategoryAjax'])->name('get.category.ajax');
        Route::post('supplier-ajax', [SupplierController::class, 'storeAjax'])->name('supplier.store.ajax');
        Route::resources([
            'products' => ProductController::class,
            'suppliers' => SupplierController::class,
            'categories' => CategoryController::class,
            'units' => UnitController::class,
            'adjustments' => AdjustmentController::class,
            'costs' => CostController::class,
            'buyers' => BuyerController::class
        ]);
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [
                UserController::class,
                'index'
            ])->name('index');
            Route::get('/admin', [UserController::class, 'getAdmin'])->name('admin');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('purchases')->name('purchases.')->group(function () {
            Route::get('/', [PurchasesController::class, 'create'])->name('create');
            Route::post('/', [PurchasesController::class, 'store'])->name('store');
            Route::get('history', [PurchasesController::class, 'history'])->name('index');
        });
        Route::prefix('selling')->name('selling.')->group(function () {
            Route::get('history', [SellingController::class, 'history'])->name('history');
        });

        Route::prefix('adjustments')->name('adjustments.')->group(function () {
            Route::post('/', [AdjustmentController::class, 'adjustmentStock'])->name('update-stock');
        });
    });
    Route::prefix('admin/selling')->name('admin.selling.')->middleware('role:admin|cashier')->group(function () {
        Route::get('history', [SellingController::class, 'history'])->name('history');
    });
    Route::prefix('accountant')->name('accountant.')->middleware("role:admin|owner")->group(function () {
        Route::get('/', function () {
            return view('dashboard.accountant.index');
        })->name('index');
        Route::get('/cost', function () {
            return view('dashboard.accountant.cost');
        })->name('cost');
    });
    Route::prefix('cashier')->name('cashier.')->middleware('role:admin|cashier')->group(function () {
        Route::get('/', [SellingController::class, 'create'])->name('index');
        Route::get('update-profile', [ProfileController::class, 'cashier'])->name('profile');
        Route::get('admin-selling-histories', [SellingController::class, 'adminSellingHistory'])->name('admin.selling.history');
        Route::get('selling-histories', [SellingController::class, 'history'])->name('selling.history');
        Route::get('show-product', [ProductController::class, 'showProduct'])->name('show.product');
        Route::get('get-last-purchases/{productUnit?}/{user?}', [PurchasesController::class, 'getLast'])->name('get.last.purchases');
        Route::post('sellings', [SellingController::class, 'store'])->name('selling.store');
        Route::post('pay-debt/{buyer}', [DebtController::class, 'payDebt'])->name('pay.debt');

        // Route::get('history-debt', [DebtController::class, 'index'])->name('history.debt');
        Route::get('debt', [DebtController::class, 'index'])->name('history.debt');
        Route::get('debt/{buyer}', [DebtController::class, 'show'])->name('detail.debt');
        // Route::get('list-user-debt', [BuyerController::class, 'listDebt'])->name('list.debt');
        // Route::get('history-pay-debt', [HistoryPayDebtController::class, 'index'])->name('history.pay.debt');
    });
});
