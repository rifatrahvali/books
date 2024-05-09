<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

// 7 - Rotamızı belirledik
Route::get('account/register',[AccountController::class,'register'])->name('account.register');
Route::post('account/register',[AccountController::class,'processRegister'])->name('account.processRegister');


// 9 - Rotamızı belirledik
Route::get('account/login',[AccountController::class,'login'])->name('account.login');
Route::post('account/login',[AccountController::class,'processLogin'])->name('account.processLogin');
