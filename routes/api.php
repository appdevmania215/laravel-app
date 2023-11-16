<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\API\ApiController;
use App\Http\Middleware\IsAdmin;

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
//API-AUTH
Route::controller(ApiController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
});
//API-Transactions
Route::prefix('transactions')->middleware('auth:sanctum')->group(function (){
    Route::post('/save',[ApiController::class,'saveTransaction'])->middleware('IsAdmin')->name('api.transactions.save');
    Route::get('/{id}',[ApiController::class,'getTransaction'])->name('api.transactions.get');
});
//API-Payments
Route::post('/payments/save',[ApiController::class,'savePayment'])->middleware('auth:sanctum','IsAdmin')->name('api.payments.save');
//API-Report
Route::post('/research',[ApiController::class,'makeResearch'])->middleware('IsAdmin')->name('api.transactions.get');
