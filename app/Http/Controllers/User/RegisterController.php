<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('user.register',[
            'title'=>'Đăng Ký'
        ]);
    }

    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:8',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/',
            'email' => 'required|email|unique:users',
            'ho_ten' => 'required|string',
            'phai' => 'required|integer|in:0,1',
            'dia_chi' => 'required|string',
            'ngay_sinh' => 'required|date',
            'role_id' => 'required|integer|exists:roles,id|default:4',
        ]);

        if ($validator->fails()) {
            // Nếu có lỗi xác thực, hiển thị chúng
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mã hóa mật khẩu
        $hashedPassword = Hash::make($request->input('password'));

        // Tạo bản ghi mới trong bảng người dùng
        User::create([
            'UserName' => $request->input('username'),
            'Password' => $hashedPassword,
            'Email' => $request->input('email'),
            'HoTen' => $request->input('ho_ten'),
            'Phai' => $request->input('phai'),
            'DiaChi' => $request->input('dia_chi'),
            'NgaySinh' => $request->input('ngay_sinh'),
            'RoleID' => $request->input('role_id', 4),
        ]);

        // Thông báo đăng ký thành công
        return redirect()->route('home')->with('success', 'Đăng ký thành công!');
    }
}
