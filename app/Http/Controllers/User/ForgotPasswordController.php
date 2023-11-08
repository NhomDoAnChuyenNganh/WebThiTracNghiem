<?php

namespace App\Http\Controllers\User;

use App\Models\Users;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('user.forgot-password',[
            'title'=>'Quên Mật Khẩu'
        ]);
    }

    public function forgotpassword(Request $request)
    {
        $username = $request->username;
        $email = $request->email;
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Users::where('username', $username)->first();


        if ($user && $user->Email == $email) {
            // Tạo token đặt lại mật khẩu
            $token = Str::random(64);

            // Lưu token vào cơ sở dữ liệu
            $user->Token = $token;
            $user->TimeReset = now()->addMinutes(2);
            $user->save(); 

            Mail::to($user->Email)->send(new ResetPasswordMail($token,$email));
            return redirect()->back()->with('success', 'Email đã được gửi. Vui lòng kiểm tra hộp thư để đặt lại mật khẩu.');
        } else {
            return redirect()->back()->with('error', 'Tên đăng nhập hoặc Email không chính xác');
        }
    }
}
