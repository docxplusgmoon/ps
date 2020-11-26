<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrencyRateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/create', [UserController::class, 'create'])->name('createUser');
Route::post('transaction/deposit', [TransactionController::class, 'deposit'])->name('deposit');
Route::post('transaction/transfer', [TransactionController::class, 'transfer'])->name('transfer');
Route::post('currency_rate/create', [CurrencyRateController::class, 'create'])->name('createCurrencyRate');
