<?php

use App\Http\Controllers\Cashier\SellingController;
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
