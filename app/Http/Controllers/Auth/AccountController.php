<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function show_account(){
        dd('vào');
        return view('Admin.pages.auth.index');
    }
    public function index()
    {
        Auth::user();
        return view('Admin.pages.auth.account');
    }

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
        Toastr::success('Đăng nhập thành công', 'success');
        return redirect()->route('diaryIndex');
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
        Toastr::success('Tạo tài khoản thành công', 'success');
        return redirect()->route('showlogin');
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            Toastr::success('Đăng xuất thành công', 'success');
            return redirect()->route('showlogin');
        } catch (\Exception $e) {
            Toastr::error('Đăng xuất thất bại', 'error');
        }
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

    public function edit_info(Request $request)
    {
        $input = $request->all();

        $rules = array(
            'name'                      => 'required',
            'number_phone'              => 'required|digits:10',
            'sex'                       => 'required',
        );
        $messages = array(
            'name.required'             => '- Tên người dùng không được để trống!',
            'sex.required'              => '- Giới tính không được để trống!',
            'number_phone.digits'       => '- Số điện thoại phải là 10 số! -'
        );
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            session()->flash('error', 'Kiểm tra lại!');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            $table                      = User::find($request->id);
            $table->name                = $request->name;
            $table->number_phone        = $request->number_phone;
            $table->sex                 = $request->sex;
            $table->address             = $request->address;
            $table->update();
            DB::commit();
            session()->flash('success', 'Cập nhật thành công!');
            Toastr::success('Cập nhật thành công', 'success');
            return redirect()->route('showAccount');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back();
        }
    }

    public function edit_pass(Request $request)
    {

        // dd($request->all());
        $input = $request->all();

        $rules = array(
            'password' => 'required|confirmed',
            // 'password_confirmation' =>'confirmed',
            'password_old' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $table = User::find($request->id);
                    $hashedPassword = $table->password;

                    if (!password_verify($value, $hashedPassword)) {
                        return $fail('Mật khẩu cũ không chính xác!');
                    }
                },
            ],

        );
        $messages = array(
            'password.required'         => '-- Mật khẩu mới không được để trống!--',
            'password_old.required'     => '-- Mật khẩu cũ không được để trống!--',
            'password.confirmed'        => '-- Mật khẩu mới không khớp nhau!--',
            // 'password_confirmation.required'        => '-- Mật khẩu mới không được để trống!--',
            // 'password_confirmation.confirmed'        => '-- Mật khẩu mới không khớp nhau!--',
        );
        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            Toastr::error('Đổi mật khẩu thất bại', 'error');
            session()->flash('error', 'Kiểm tra lại!');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // dd($request->all());
        DB::beginTransaction();
        try {
            $table                          = User::find($request->id);
            $hashedPassword = $table->password;
            if (password_verify($request->password_old, $hashedPassword)) {
                $table->password                = Hash::make($request->password);
                $table->update();
            } else {
                // session()->flash('success', 'Đổi mật khẩu thành công!');
                Toastr::error('Đổi mật khẩu thất bại', 'error');
                return redirect()->route('showAccount');
            }
            DB::commit();
            session()->flash('success', 'Đổi mật khẩu thành công!');
            Toastr::success('Đổi mật khẩu thành công', 'success');
            return redirect()->route('showAccount');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back();
        }
    }
}
