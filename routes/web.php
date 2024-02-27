<?php

use Illuminate\Support\Facades\Route;
include __DIR__.'/admin.php';
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

Route::get('1', function () {
    return view('welcome');
});
Route::get('pusher', function () {
    return view('Admin.pages.test.test_pusher');
});
Route::get('/test_select2', function () {
    return view('Admin.pages.test.testselect2');
});
