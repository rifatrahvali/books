<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('welcome');
});

// 7 - Rotamızı belirledik
Route::get('account/register',[AccountController::class,'register'])->name('account.register');
Route::post('account/register',[AccountController::class,'processRegister'])->name('account.processRegister');
