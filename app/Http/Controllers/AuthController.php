<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    function login()
    {

        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($data, $request->has('remember'))) {
            // code...
            return redirect()->route('dashboard')->with('notification_success', 'Đăng nhập thành công !!!');
        } else {
            return redirect()->back()->withInput()->with('notification_error', 'Tài khoản hoặc mật khẩu không chính xác !!!');
        }
    }

    public function logout()
    {
        // code...
        Auth::logout();
        return redirect()->route('login');
    }

    function profile(Request $request)
    {
        if ($request->_method == 'post') {
            $data = array_filter($request->only(['name', 'gender', 'address', 'password']));
            $validator = Validator::make($data, [
                'name' => 'required',
                'password' => 'sometimes|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();
                if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
                Auth::user()->update($data);
                DB::commit();
                return redirect()->back()->with('notification_success', 'Thành công');
            } catch (\Exception $ex) {
                DB::rollback();
                return redirect()->back()->with('notification_error', 'Lỗi');
            }
        }
        $data = [
            'row' => Auth::user(),
            'title' => 'Thông tin cá nhân',
            'action' => route('profile'),
            'method' => 'post'
        ];
        return view('auth.profile', $data);
    }

    public function forgotPassword(Request $request)
    {
        if ($request->_method == 'post') {
            $user = User::where('email', $request->email)->first();

            if (empty($user)) return back()->with('notification_error', 'Lỗi !!! Không tồn tại người dùng');
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }
            return redirect()->back()->with('notification_success', 'Thành công !!!');
        }
        return view('auth.forgot');
    }

//    function postForgotPassword(Request $request)
//    {
//        dd($request->)
//        if ($request->_method == 'post') {
//            dd($request->all());
//            $user = User::where('email', $request->email)->firstOrFail();
//            if (empty($user)) return back()->with('notification_error', 'Lỗi !!! Không tồn tại người dùng');
//            $passwordReset = PasswordReset::updateOrCreate([
//                'email' => $user->email,
//            ], [
//                'token' => Str::random(60),
//            ]);
//            if ($passwordReset) {
//                $user->notify(new ResetPasswordRequest($passwordReset->token));
//            }
//
//            return redirect()->back()->with('notification_success', 'Thành công !!!');
//        }
//    }

    public function reset(Request $request, $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if ($request->_method == 'post') {
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
                $passwordReset->delete();
                return redirect()->back()->with('notification_error', 'Lỗi !!!');
            }
            $user = User::where('email', $passwordReset->email)->firstOrFail();

            $user->password=  Hash::make($request->password);
            $user->save();
            $passwordReset->delete();
            return redirect()->route('login')->with('notification_success', 'Thành công !!!');
        }
        return view('auth.reset');
    }
}
