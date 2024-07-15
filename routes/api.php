<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchasesController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Cashier\SellingController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\HistoryPayDebtController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Api List
Route::get("/list-buyer",[SellingController::class, 'listBuyer'])->name('buyer.list-search');
Route::get("/list-category",[CategoryController::class, 'listCategory'])->name('category.list-search');
Route::get("/list-supplier",[SupplierController::class, 'listSupplier'])->name('supplier.list-search');
Route::get('/list-product', [ProductController::class, 'listProduct'])->name('product.list-search');
Route::get("/data-history-transaction/by-buyer",[SellingController::class, 'dataUserTransactionHistoryLatest'])->name('transaction.find-by-user-product');

// Route api for data table
Route::name('data-table.')->prefix('data-table')->group(function() {
    // data master
    Route::get("/list-purchase-history", [PurchasesController::class, 'tablePurchaseHistory'])->name('list-purchase-history');
    Route::get("/list-transaction-history", [SellingController::class, 'tableTransactionHistory'])->name('list-transaction-history');
    Route::get("/list-debt-history", [SellingController::class, 'tableDebtHistory'])->name('list-debt-history');
    Route::get("/list-pay-debt-history", [HistoryPayDebtController::class, 'tablePayDebtHistory'])->name('list-pay-debt-history');

    Route::get('/list-debt', [DebtController::class, 'tableDebt'])->name('list-debt');
    Route::get('/list-product', [ProductController::class, 'dataTable'])->name('list-product');
    Route::get('/list-cashier', [UserController::class, 'tableCashier'])->name('list-cashier');
    Route::get('/list-supplier', [SupplierController::class, 'tableSupplier'])->name('list-supplier');
    Route::get('/list-category', [CategoryController::class, 'tableCategory'])->name('list-category');
    Route::get('/list-unit', [UnitController::class, 'tableUnit'])->name('list-unit');
    
    // data dashboard
    Route::get('/list-high-transaction', [SellingController::class, 'tableUserHighTransaction'])->name('list-high-transaction');
});

// Ruoute Api Transaction
Route::post('/create-supplier',[SupplierController::class, 'storeAjax'])->name('api.supplier.store.ajax');
Route::post('/create-category', [CategoryController::class, 'storeAjax'])->name('api.category.store.ajax');
Route::post('/create-unit', [UnitController::class, 'storeAjax'])->name('api.unit.store.ajax');

// Route for api chart
Route::name('chart.')->prefix('chart')->group(function() {
    Route::get('/chart-penjualan',[ChartController::class, 'chartPenjualan'])->name('penjualan');
    Route::get('/dashboard/chart-card',[ChartController::class, 'chartCard'])->name('card.dashboard');
});

// Route api for find data
Route::name('find.')->prefix('find')->group(function (){
    Route::get('/user/by-name-address', [UserController::class, 'findUser'])->name('user.email-address');
    Route::get('/buyer/{buyer}', [BuyerController::class, 'findBuyerById'])->name('buyer.by-id');
    Route::get('/buyer/by-name-address', [BuyerController::class, 'findBuyer'])->name('buyer.name-address');
    Route::get('/product/last-product', [UserController::class, 'lastProduct'])->name('product.last-product');
});