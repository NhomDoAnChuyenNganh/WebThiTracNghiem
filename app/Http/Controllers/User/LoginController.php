<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function index()
    {
        return view('user.login',[
            'title'=>'Đăng Nhập Hệ Thống'
        ]);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

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

        $user = User::where('username', $username)->first();

        if ($user && Hash::check( $password, $user->password)) {
            // Đăng nhập thành công
            // Thực hiện hành động sau đăng nhập
        } else {
            return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không chính xác');
        }
    }

}
