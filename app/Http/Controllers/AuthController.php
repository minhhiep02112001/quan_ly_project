<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    function forgot()
    {
        return view('auth.forgot');
    }

    function forgotPassword(Request $request)
    {

    }

    public function logout()
    {
        // code...
        Auth::logout();
        return redirect()->route('admin.login');
    }

    function profile(Request $request)
    {
        if ($request->_method == 'post') {
            $data = array_filter($request->only(['name', 'gender', 'address' , 'password']));
            $validator = Validator::make($data, [
                'name' => 'required',
                'password' => 'sometimes|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                DB::beginTransaction();
                if (!empty( $data['password'])) $data['password'] = Hash::make($data['password']);
                Auth::user()->update($data);
                DB::commit();
                return redirect()->back()->with('notification_success', 'Thành công');
            }catch (\Exception $ex){
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
}
