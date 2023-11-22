<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register'])->middleware('auth:sanctum');
});

//Route::middleware(['auth:sanctum'])->group(function () {
//    Route::get('/donors', [DonorController::class, 'index']);
//    Route::post('/donors', [DonorController::class, 'store']);
//    Route::get('/donors/{donorId}', [DonorController::class, 'show']);
//    Route::put('/donors/{donorId}', [DonorController::class, 'update']);
//    Route::delete('/donors/{donorId}', [DonorController::class, 'destroy']);
//    Route::post('donors/{donorId}/transactions/{transactionId}/approve', [DonorController::class, 'transactionStatusApprove']);
//
//    Route::post('/transactions', [TransactionController::class, 'store']);
//    Route::get('/transactions', [TransactionController::class, 'index']);
//    Route::get('/transactions/{donorId}', [TransactionController::class, 'getDonorTransactions']);
//});


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
