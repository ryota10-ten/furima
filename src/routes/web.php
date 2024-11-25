<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MiddlewareController;

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


Route::get('/register', [UserController::class, 'register']);

Route::post('/mypage/profile/', [UserController::class, 'store']);
Route::get('/mypage/profile/', [UserController::class, 'edit']);
Route::post('/',[UserController::class,'add']);
Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index']);
});

Route::get('/', [ItemController::class,'index']);

Route::get('/login',[LoginController::class,'login']);