<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Diary\Testcontroller;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('login', [AccountController::class, 'login'])->name('showlogin');
    Route::get('register', [AccountController::class, 'register'])->name('showregister');


    Route::get('test',[Testcontroller::class,'index'])->name('index_test');
});
