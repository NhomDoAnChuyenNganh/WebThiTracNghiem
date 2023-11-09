<?php

namespace App\Http\Controllers\User;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function index($token) {
        $user = Users::where('Token', $token)->first();

        // Kiểm tra xem người dùng có tồn tại và thời gian reset còn hợp lệ không
        if ($user && $user->TimeReset > now()) {
            return view('user.reset-password', ['token' => $token]);
        } else {
            $user->Token = null;
            $user->TimeReset = null;
            $user->save();
            abort(404, 'Liên kết đặt lại mật khẩu đã hết hạn hoặc không hợp lệ.');
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matkhau' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/',
            'nhaplai' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/',
        ]);

        if ($validator->fails()) {
            // Nếu có lỗi xác thực, hiển thị chúng
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $password = $request->matkhau;
        $confirmPassword = $request->nhaplai;
        $email = urldecode($request->query('email'));

        if ($password === $confirmPassword) {
            // Cập nhật mật khẩu mới
            $user = Users::where('Email', $email)->first();
            $user->Password = Hash::make($password);
            $user->Token = null;
            $user->TimeReset = null; // Có thể cần xóa thời gian reset
            $user->save();

            // Redirect hoặc thông báo thành công
            return redirect('user/login');
        } else {
            return redirect()->back()->with('error', 'Mật khẩu và xác nhận mật khẩu không khớp.');
        }
    }
}