<?php

namespace App\Http\Controllers\User;

use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        $user = Session::get('user');
        if ($user) {
            return redirect('/');
        }

        return view('user.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        // $username = $request->input('username');
        // $password = $request->input('password');

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Users::where('username', $username)->first();


        if ($user && Hash::check($password, $user->Password)) {
            Session::put('user', $user);
            if ($user->RoleID == 1) {
                return redirect()->route('trang-chu-quan-ly');
            } elseif ($user->RoleID == 2) {
                return redirect()->route('trang-chu-giao-vien-soan-de');
            } elseif ($user->RoleID == 3) {
                return redirect()->route('trang-chu-can-bo-coi-thi');
            } else {
                return redirect()->route('trang-chu-sinh-vien');
            }
        } else {
            return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không chính xác');
        }
    }
    public function logout()
    {
        // Xóa thông tin người dùng khỏi session
        Session::forget('user');

        // Hoặc sử dụng Session::flush() để xóa tất cả dữ liệu trong session
        // Session::flush();

        // Chuyển hướng hoặc thực hiện các hành động khác sau khi đăng xuất
        return redirect()->route('login');
    }
}
