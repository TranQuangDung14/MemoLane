<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Diary\DiaryController;
use App\Http\Controllers\Diary\Testcontroller;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    // đăng nhập
    Route::get('login', [AccountController::class, 'showlogin'])->name('showlogin');
    Route::post('login', [AccountController::class, 'login'])->name('login');
    // đăng ký
    Route::get('register', [AccountController::class, 'showregister'])->name('showregister');
    Route::post('register', [AccountController::class, 'register'])->name('register');
    //đăng xuất
    Route::post('logout', [AccountController::class, 'logout'])->name('logout');
    
    Route::prefix('')->middleware('auth')->group(function () {
        Route::get('test',[Testcontroller::class,'index'])->name('index_test');


        Route::get('my_diary', [DiaryController::class, 'index'])->name('my_diary');
        // Route::get('add', [CategoriesController::class, 'create'])->name('categoryCreate');
        // Route::post('add', [CategoriesController::class, 'store'])->name('categoryStore');
        // Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('categoryEdit');
        // Route::get('update/{id}', [CategoriesController::class, 'update'])->name('categoryUpdate');
        // Route::delete('delete/{id}', [CategoriesController::class, 'delete'])->name('categoryDelete');
    });
});
