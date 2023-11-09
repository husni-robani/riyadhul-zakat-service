<?php

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
Route::group([
    'middleware' => config('fortify.middleware', ['web'])
],function (){
    //Authenticated route
    Route::group([
        'middleware' => [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')]
    ], function (){
        //donors service
        Route::get('/donors', [DonorController::class, 'index']);
        Route::post('/donors', [DonorController::class, 'store']);
        Route::get('/donors/{donorId}', [DonorController::class, 'show']);
        Route::put('/donors/{donorId}', [DonorController::class, 'update']);
        Route::delete('/donors/{donorId}', [DonorController::class, 'destroy']);

        //transactions service
        Route::post('/transactions', [TransactionController::class, 'store']);
    });
});
