<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Diary\DiaryController;
use App\Http\Controllers\Diary\Testcontroller;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    //Thông tin tài khoản
    Route::get('My_account', [AccountController::class, 'index'])->middleware('auth')->name('showAccount');
    
    // cập nhật thông tin tài khoản
    Route::put('update_account', [AccountController::class, 'edit_info'])->middleware('auth')->name('accountUpdate');
    
    //Đổi mật khẩu
    Route::put('update_pass_account', [AccountController::class, 'edit_pass'])->middleware('auth')->name('accountUpdatePass');
    
    // đăng nhập
    Route::get('login', [AccountController::class, 'showlogin'])->name('showlogin');
    Route::post('login', [AccountController::class, 'login'])->name('login');
    // đăng ký
    Route::get('register', [AccountController::class, 'showregister'])->name('showregister');
    Route::post('register', [AccountController::class, 'register'])->name('register');
    //đăng xuất
    Route::post('logout', [AccountController::class, 'logout'])->middleware('auth')->name('logout');

    Route::prefix('')->middleware('auth')->group(function () {
        Route::get('test',[Testcontroller::class,'index'])->name('index_test');


        // Route::get('add', [CategoriesController::class, 'create'])->name('categoryCreate');
        // Route::post('add', [CategoriesController::class, 'store'])->name('categoryStore');
        // Route::get('edit/{id}', [CategoriesController::class, 'edit'])->name('categoryEdit');
        // Route::get('update/{id}', [CategoriesController::class, 'update'])->name('categoryUpdate');
        // Route::delete('delete/{id}', [CategoriesController::class, 'delete'])->name('categoryDelete');
    });
    Route::prefix('my_diary')->middleware('auth')->group(function () {
        
        Route::get('create', [DiaryController::class, 'create'])->name('my_diaryCreate');
        
        Route::get('{id}', [DiaryController::class, 'MyDiary'])->name('my_diaryIndex');
        
        Route::post('store', [DiaryController::class, 'store'])->name('my_diaryStore');
    });
});
