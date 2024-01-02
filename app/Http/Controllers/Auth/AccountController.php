<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function showlogin()
    {
        if (auth()->check()) {
            if (auth()->user()->role === 1) {
                return redirect()->back();
            }
        }
        return view('Admin.pages.auth.login');
    }

    public function login(Request $request)
    {
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
        } elseif ($user->status != 0) {
            if ($user->status == 1) {
                session()->flash('error', 'Tài khoản này đã bị khóa tạm thời!');
                return redirect()->route('showlogin');
            } else {
                session()->flash('error', 'Tài khoản này đã bị khóa vĩnh viễn!');
                return redirect()->route('showlogin');
            }
        }

        Auth::login($user);

        // Xử lý khi người dùng đăng nhập thành công
        // return response()->json(['message' => 'Đăng nhập thành công!']);

        return redirect()->route('index_test');
    }

    public function showregister()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return view('Admin.pages.auth.register');
    }
    public function register(Request $request)
    {
        // dd($request->all()); 
        try {
            $input = $request->all();
            $rules = array(
                // 'name' => 'required',
                'name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
            );
            $messages = array(
                'name.required'     => '--Tên người dùng không được để trống!--',
                'email.required'    => '--Email không được để trống!--',
                'email.string'      => '--Email phải là chuỗi!--',
                'email.email'       => '--Email không hợp lệ!--',
                'email.max'         => '--Email không được vượt quá 255 ký tự!--',
                'email.unique'      => '--Email đã tồn tại trong hệ thống!--',
                'password.required' => '--Mật khẩu không được để trống!--',
            );
            $validator = Validator::make($input, $rules, $messages);

            if ($validator->fails()) {
                // $errorMessage = implode(' ', $validator->errors()->all());
                session()->flash('error', 'Kiểm tra lại!');
                // session()->flash('error', $errorMessage);
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'sex'           => $request->sex ?? null,
                'role'          => 1,
                'status'        => 0,
                'address'       => $request->address ?? '',
                'number_phone'  => $request->number_phone ?? '',
            ]);

            // Auth::login($user);
        } catch (\Exception $e) {
            dd($e);
        }
        return redirect()->route('showlogin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('showlogin');
    }

    public function lock_account(Request $request)
    {
        // dd($request->all());
        try {
            $user = User::find($request->id);

            if ($request->status == 1) {
                $status = 1;
                session()->flash('success', 'Đã khóa tạm thời tài khoản ' . $user->name . ' thành công.');
            } elseif ($request->status == 2) {
                $status = 2;
                session()->flash('success', 'Đã khóa tài khoản ' . $user->name . ' vĩnh viễn thành công.');
            } else {
                $status = 0;
                session()->flash('success', 'Đã mở khóa ' . $user->name . ' thành công.');
            }
            $user->status      = $status;
            $user->save();

            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'Có lỗi bất ngờ xảy ra!');
            // Toastr::error('kích hoạt thất bại!', 'Failed');
            return redirect()->back();
        }
    }
}
