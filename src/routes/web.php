<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'resend'])->name('verification.send');

Route::get('/register', [UserController::class, 'register']);
Route::post('/mypage/profile/', [UserController::class, 'store']);

Route::post('/',[UserController::class,'add']);

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'login']);

Route::get('/', [IndexController::class,'index']);
Route::get('/search',[IndexController::class,'search']);

Route::get('/item/{id}', [ProductController::class, 'show'])->name('item.show');
Route::middleware('auth')->group(function () {
    Route::post('/logout',[LoginController::class,'logout']);
    Route::post('/comments', [ProductController::class, 'store']);
    Route::post('/item/{id}/like', [ProductController::class, 'favorite']);
    Route::get('/mypage',[ProfileController::class,'mypage']);
    Route::get('/mypage/profile/', [UserController::class, 'edit']);
    Route::get('/sell',[SellController::class,'sell']);
    Route::post('/sell',[SellController::class,'store'])->name('sell.store');
    Route::get('/purchase/{id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{id}',[PurchaseController::class,'buy']);
    Route::post('/purchase/method/{id}', [PurchaseController::class, 'updateMethod'])->name('purchase.method');
    Route::get('/purchase/address/{id}',[PurchaseController::class, 'edit']);
    Route::post('/purchase/address/{id}',[PurchaseController::class, 'update'])->name('purchase.address.update');
    Route::post('/purchase/fix/{id}',[PurchaseController::class,'fix'])->name('purchase.fix');
    Route::get('/success', [PurchaseController::class, 'success'])->name('success');
    Route::get('/cancel', [PurchaseController::class, 'cancel'])->name('cancel');
});