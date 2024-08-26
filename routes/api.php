<?php

use App\Http\Controllers\AdjustmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchasesController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Cashier\SellingController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\DashboardController;
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
Route::get('/list-year', [DashboardController::class, 'listTahun'])->name('dashboard.list-tahun');
Route::get("/list-buyer", [SellingController::class, 'listBuyer'])->name('buyer.list-search');
Route::get("/list-category", [CategoryController::class, 'listCategory'])->name('category.list-search');
Route::get("/list-supplier", [SupplierController::class, 'listSupplier'])->name('supplier.list-search');
Route::get('/list-product', [ProductController::class, 'listProduct'])->name('product.list-search');
Route::get('/list-cost-category', [CostController::class, 'listCategory'])->name('cost.category.list-search');
Route::get("/data-history-transaction/by-buyer", [SellingController::class, 'dataUserTransactionHistoryLatest'])->name('transaction.find-by-user-product');

// Route api for data table
Route::name('data-table.')->prefix('data-table')->group(function () {
    // data master
    Route::get("/list-purchase-history", [PurchasesController::class, 'tablePurchaseHistory'])->name('list-purchase-history');
    Route::get("/list-transaction-history", [SellingController::class, 'tableTransactionHistory'])->name('list-transaction-history');
    Route::get("/list-debt-history", [SellingController::class, 'tableDebtHistory'])->name('list-debt-history');
    Route::get("/list-pay-debt-history", [HistoryPayDebtController::class, 'tablePayDebtHistory'])->name('list-pay-debt-history');
    Route::get("/list-adjustment-history", [AdjustmentController::class, 'tableAdjustmentHistory'])->name('list-adjustment-history');

    Route::get('/list-debt', [DebtController::class, 'tableDebt'])->name('list-debt');
    Route::get('/list-debt/by-buyer/{buyer}', [DebtController::class, 'tableDetailDebt'])->name('list-detail-debt');
    Route::get('/list-product', [ProductController::class, 'dataTable'])->name('list-product');
    Route::get('/list-product/by-product/{product}', [ProductController::class, 'dataDetailTable'])->name('list-detail-product');
    Route::get('/list-cashier', [UserController::class, 'tableCashier'])->name('list-cashier');
    Route::get('/list-supplier', [SupplierController::class, 'tableSupplier'])->name('list-supplier');
    Route::get('/list-category', [CategoryController::class, 'tableCategory'])->name('list-category');
    Route::get('/list-unit', [UnitController::class, 'tableUnit'])->name('list-unit');
    Route::get('/list-cost', [CostController::class, 'tableCost'])->name('list-cost');
    Route::get('/list-buyer', [BuyerController::class, 'tableBuyer'])->name('list-buyer');

    // data dashboard
    Route::get('/list-high-transaction', [SellingController::class, 'tableUserHighTransaction'])->name('list-high-transaction');
});

// Ruoute Api Transaction
Route::post('/create-supplier', [SupplierController::class, 'storeAjax'])->name('api.supplier.store.ajax');
Route::post('/create-category', [CategoryController::class, 'storeAjax'])->name('api.category.store.ajax');
Route::post('/create-unit', [UnitController::class, 'storeAjax'])->name('api.unit.store.ajax');
Route::post('/create-cost-category', [CostController::class, 'createCategory'])->name('api.cost.category.store.ajax');

Route::post('/update-product-price', [ProductController::class, 'updatePriceProduct'])->name('api.product.update.price.ajax');

// Route for api chart
Route::name('chart.')->prefix('chart')->group(function () {
    Route::get('/chart-penjualan', [ChartController::class, 'chartPenjualan'])->name('penjualan');
    Route::get('/dashboard/chart-card', [ChartController::class, 'chartCard'])->name('card.dashboard');
});

// Route api for find data
Route::name('find.')->prefix('find')->group(function () {
    Route::get('/user/by-name-address', [UserController::class, 'findUser'])->name('user.email-address');
    Route::name('buyer.')->prefix('buyer')->group(function () {
        Route::get('/by-name-address', [BuyerController::class, 'findBuyer'])->name('name-address');
        Route::post('/check-code', [BuyerController::class, 'checkCodeBuyer'])->name('check-code');
        Route::get('/{buyer}', [BuyerController::class, 'findBuyerById'])->name('by-id');
    });
    Route::name('product.')->prefix('product')->group(function () {
        Route::get('/last-purchase', [PurchasesController::class, 'dataProductLastPurchase'])->name('last-purchase');
        Route::get('/last-product', [ProductController::class, 'lastProduct'])->name('last-product');
        Route::post('/check-code', [ProductController::class, 'checkCodeProduct'])->name('check-code');
    });
});

Route::get('summary/laba-rugi', [CostController::class, 'sumLabaRugi'])->name('laba-rugi');
Route::prefix('print')->name('print.')->group(function(){
    Route::post('product', [ProductController::class, 'printProduct'])->name('product');
    Route::post('buyer', [ BuyerController::class, 'printBuyer'])->name('buyer');
    Route::post('stockOpname', [ ProductController::class, 'printOpname'])->name('stock-opname');
    Route::get('transaction-history/{selling}', [SellingController::class, 'printHistoryTransaction'])->name('transaction-history');
});
