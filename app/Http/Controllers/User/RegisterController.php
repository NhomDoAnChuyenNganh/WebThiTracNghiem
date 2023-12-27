<?php

namespace App\Http\Controllers\User;

use App\Models\Users;
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
            'username' => 'required|min:8|unique:users,UserName',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/',
            'email' => 'required|email|unique:users',
            'hoten' => 'required|string|regex:/^[^\d!@#$%^&*]+$/',
            'phai' => 'required|integer|in:0,1',
            'diachi' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'ngaysinh' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
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
        $user = new Users();

        $user->UserName = $request->input('username');
        $user->Email = $request->input('email');
        $user->Password = $hashedPassword;
        $user->HoTen = $request->input('hoten');
        $user->Phai = $request->input('phai');
        $user->DiaChi = $request->input('diachi');
        $user->TinhThanh = $request->input('city');
        $user->QuanHuyen = $request->input('district');
        $user->PhuongXa = $request->input('ward');
        $user->NgaySinh = $request->input('ngaysinh');
        $user->RoleID = 4;
         

        $user->save();

        return redirect('user/login');
    }
}
