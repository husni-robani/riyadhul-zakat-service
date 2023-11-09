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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::group([
    'middleware' => ['auth:sanctum']
], function (){
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    //donors service
    Route::get('/donors', [DonorController::class, 'index']);
    Route::post('/donors', [DonorController::class, 'store']);
    Route::get('/donors/{donorId}', [DonorController::class, 'show']);
    Route::put('/donors/{donorId}', [DonorController::class, 'update']);
    Route::delete('/donors/{donorId}', [DonorController::class, 'destroy']);
    Route::post('donors/{donorId}/transactions/{transactionId}/approve', [DonorController::class, 'transactionStatusApprove']);

    //transactions service
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{donorId}', [TransactionController::class, 'getDonorTransactions']);
});
