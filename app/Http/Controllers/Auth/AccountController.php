<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function login(){
        return view('Admin.pages.auth.login');
    }
    public function register(){
        return view('Admin.pages.auth.register');
    }
}
