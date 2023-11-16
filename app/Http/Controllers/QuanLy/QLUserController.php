<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Role;
use Illuminate\Http\Request;
use PHPUnit\Metadata\Uses;

class QLUserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = Users::all();
        return view('quanly.ql-user', [
            'title' => 'Quản Lý',
            'dsusers' => $users,
            'dsrole' => $roles,
        ]);
    }
    public function getUsersByRole(Request $request)
    {
        $roleId = $request->input('role_id');

        if ($roleId == null) {
            $users = Users::all();
        } else {
            $users = Users::where('RoleID', $roleId)->get();
        }


        $roles = Role::all();
        return view('quanly.ql-user', [
            'title' => 'Quản Lý',
            'dsusers' => $users,
            'dsrole' => $roles,
        ]);
    }
    public function them()
    {
    }
    public function deleteUser($id)
    {
        $user = Users::where('UserID', $id)->first();

        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
            return redirect()->route('ql-user')->with('error', 'Không tìm thấy người dùng.');
        }

        // Bước 2: Thực hiện xóa người dùng
        $user->delete();

        // Bước 3: Chuyển hướng người dùng đến trang danh sách người dùng
        return redirect()->route('ql-user')->with('success', 'Người dùng đã được xóa thành công.');
    }
    public function edituser($id)
    {
        // Lấy thông tin người dùng từ ID
        $user = Users::where('UserID', $id)->first();

        // Trả về view form sửa và truyền thông tin người dùng
        $roles = Role::all();
        return view('quanly.edit-user', [
            'title' => 'Sửa người dùng',
            'user' => $user,
            'dsrole' => $roles,
        ]);
    }
    public function updateuser(Request $request, $id)
    {
        // Lấy thông tin người dùng từ ID
        $user = Users::where('UserID', $id)->first();
        // Cập nhật thông tin người dùng dựa trên dữ liệu từ request
        $user->HoTen = $request->hoten;
        $user->Email = $request->email;
        $user->NgaySinh = $request->ngaysinh;
        $user->DiaChi = $request->diachi;
        $user->Phai = $request->phai;
        $user->RoleID = $request->role_id_;

        $user->save();

        // Chuyển hướng về trang danh sách người dùng sau khi cập nhật
        return redirect()->route('ql-user')->with('success', 'Người dùng đã được cập nhật thành công.');
    }
}
