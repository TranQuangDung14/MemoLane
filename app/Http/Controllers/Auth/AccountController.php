<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function showlogin(){
        return view('Admin.pages.auth.login');
    }

    public function login(Request $request)
    {
        dd('vào');
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // return response()->json(['message' => 'Thông tin tài khoản mật khẩu không chính xác!'], 401);
            // dd('2');
            // dd($credentials);
            session()->flash('error', 'Thông tin tài khoản mật khẩu không chính xác!');
            return redirect()->route('showlogin');
        } elseif ($user->role !== 1) {
            session()->flash('error', 'Tài khoản này không có quyền đăng nhập vào admin!');
            return redirect()->route('showlogin');
        }
        elseif ($user->status != 0 ) {
            if($user->status ==1){
                session()->flash('error', 'Tài khoản này đã bị khóa tạm thời!');
                return redirect()->route('showlogin');
            }
            else{
                session()->flash('error', 'Tài khoản này đã bị khóa vĩnh viễn!');
                return redirect()->route('showlogin');
            }
        }

        Auth::login($user);

        // Xử lý khi người dùng đăng nhập thành công
        // return response()->json(['message' => 'Đăng nhập thành công!']);

        return redirect()->route('index_test');
    }

    public function showregister(){
        return view('Admin.pages.auth.register');
    }
}
