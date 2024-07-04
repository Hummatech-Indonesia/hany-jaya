<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Cashier\SellingController;
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

Route::get("/list-buyer",[SellingController::class, 'listBuyer'])->name('buyer.list-search');
Route::get("/data-history-transaction/by-buyer",[SellingController::class, 'dataUserTransactionHistoryLatest'])->name('transaction.find-by-user-product');

// Route api for data table
Route::name('data-table.')->prefix('data-table')->group(function() {
    Route::get("/list-transaction-history", [SellingController::class, 'tableTransactionHistory'])->name('list-transaction-history');
    Route::get('/list-product', [ProductController::class, 'dataTable'])->name('list-product');
    Route::get('/list-cashier', [UserController::class, 'tableCashier'])->name('list-cashier');
    Route::get('/list-supplier', [SupplierController::class, 'tableSupplier'])->name('list-supplier');
});
