<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ResearchController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//AUTH
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Transactions
Route::get('/transactions',[TransactionController::class,'index'])->name('transactions');
Route::get('/transactions/edit',function (){
    return view('transactions.edit');
})->middleware(['auth','IsAdmin'])->name('transactions.edit');
Route::post('/transactions/save',[TransactionController::class,'save'])->middleware(['auth','IsAdmin'])->name('transactions.save');
Route::get('/transactions/{id}',[TransactionController::class,'read'])->name('transactions.read');

//Payments
Route::get('/payments',[PaymentController::class,'index'])->name('payments');
Route::get('/transactions/{id}/add-payment',function (int $id){
    return view('payments.edit',['transaction'=>$id]);
})->middleware(['auth','IsAdmin'])->name('payments.edit');
Route::post('/payments/save',[PaymentController::class,'save'])->middleware(['auth','IsAdmin'])->name('payments.save');

//Research
Route::get('/research',[ResearchController::class,'index'])->middleware(['auth','IsAdmin'])->name('research');
Route::post('/research',[ResearchController::class,'research'])->middleware(['auth','IsAdmin'])->name('research.research');



require __DIR__.'/auth.php';
