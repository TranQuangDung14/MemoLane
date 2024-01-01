<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Diary\Testcontroller;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    Route::get('login', [AccountController::class, 'showlogin'])->name('showlogin');
    Route::post('login', [AccountController::class, 'showlogin'])->name('login');

    Route::get('register', [AccountController::class, 'showregister'])->name('showregister');


    Route::prefix('')->middleware('auth','admin')->group(function () {
        Route::get('test',[Testcontroller::class,'index'])->name('index_test');


        // Route::get('', [CategoriesController::class, 'index'])->name('categoryIndex');
        // Route::get('add', [CategoriesController::class, 'create'])->name('categoryCreate');
        // Route::post('add', [CategoriesController::class, 'store'])->name('categoryStore');
        // Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('categoryEdit');
        // Route::get('update/{id}', [CategoriesController::class, 'update'])->name('categoryUpdate');
        // Route::delete('delete/{id}', [CategoriesController::class, 'delete'])->name('categoryDelete');
    });
});
