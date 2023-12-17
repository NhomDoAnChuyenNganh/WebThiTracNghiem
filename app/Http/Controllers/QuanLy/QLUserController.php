<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use PHPUnit\Metadata\Uses;

class QLUserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = Users::orderBy('UserID', 'desc')->paginate(10);
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
            $users = Users::paginate(10);
        } else {
            $users = Users::where('RoleID', $roleId)->paginate(10);
        }


        $roles = Role::all();
        return view('quanly.ql-user', [
            'title' => 'Quản Lý',
            'dsusers' => $users,
            'dsrole' => $roles,
        ]);
    }
    public function indexinsert()
    {
        $roles = Role::all();
        return view('quanly.insert-user', [
            'title' => 'Thêm Người Dùng',
            'dsrole' => $roles,
        ]);
    }
    public function insertUser(Request $request)
    { 
            // Xác thực dữ liệu đầu vào
            $validator = Validator::make($request->all(), [
                'username' => 'required|min:8|unique:users,UserName',
                'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/',
                'email' => 'required|email|unique:users',
                'hoten' => 'required|string',
                'phai' => 'required|integer|in:0,1',
                'diachi' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'ward' => 'required|string',
                'ngaysinh' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'role_id' => 'required|integer',
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
            $user->RoleID = (int)$request->input('role_id');

            $user->save();


            return redirect()->route('ql-user')->with('success', 'Người dùng đã được thêm thành công.');
        
    }
    public function deleteUser($id)
    {
        $user = Users::where('UserID', $id)->first();

        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
            return redirect()->route('ql-user')->with('error', 'Không tìm thấy người dùng.');
        }

        
        try {
            // Bước 2: Thực hiện xóa người dùng
            $user->delete();

            // Bước 3: Chuyển hướng người dùng đến trang danh sách người dùng
            return redirect()->route('ql-user')->with('success', 'Người dùng đã được xóa thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Không thể xóa user này do tồn tại các mối quan hệ liên quan.');
            }
        }
    }
    public function edituser($id)
    {
        // Lấy thông tin người dùng từ ID
        $user = Users::where('UserID', $id)->first();

        // Trả về view form sửa và truyền thông tin người dùng
        $roles = Role::all();
        return view('quanly.edit-user', [
            'title' => 'Edit Người Dùng',
            'user' => $user,
            'dsrole' => $roles,
        ]);
    }
    public function updateuser(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'hoten' => 'required|string',
            'phai' => 'required|integer|in:0,1',
            'diachi' => 'required|string',
            'ngaysinh' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'role_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            // Nếu có lỗi xác thực, hiển thị chúng
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Lấy thông tin người dùng từ ID
        $user = Users::where('UserID', $id)->first();
        // Cập nhật thông tin người dùng dựa trên dữ liệu từ request
        $user->HoTen = $request->hoten;
        $user->Email = $request->email;
        $user->NgaySinh = $request->ngaysinh;
        $user->DiaChi = $request->diachi;
        $user->PhuongXa = $request->ward;
        $user->QuanHuyen = $request->district;
        $user->TinhThanh = $request->city;
        $user->Phai = $request->phai;
        $user->RoleID = $request->role_id;


        $user->save();

        // Chuyển hướng về trang danh sách người dùng sau khi cập nhật
        return redirect()->route('ql-user')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    public function processFile(Request $request)
    {
        // Kiểm tra xem tệp đã được gửi lên hay không
        if ($request->hasFile('user_file')) {
            // Lấy tệp từ biểu mẫu
            $file = $request->file('user_file');

            // Kiểm tra định dạng tệp
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx') {

                // Đọc và xử lý tệp
                $usersData = $this->processExcelFile($file);

                foreach ($usersData as $userData) {
                    Users::create($userData);
                }
                return redirect()->route('ql-user')->with('success', 'Đã thêm danh sách thành công');
            } else {
                // Định dạng không hỗ trợ
                return redirect()->route('ql-user')->with('error', 'Định dạng tệp chỉ hỗ trợ Excel');
            }
        }

        // Không có tệp được gửi lên
        return redirect()->route('ql-user')->with('error', 'Vui lòng chọn một tệp để xử lý');
    }

    private function processExcelFile($file)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file->getPathname());

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();

        $genderMappings = [
            'Nam' => 0,
            'Nu' => 1,
        ];

        $roleMappings = [
            'Quan Ly' => 1,
            'Giao Vien' => 2,
            'Can Bo' => 3,
            'Sinh Vien' => 4,
        ];

        $usersData = [];

        for ($row = 2; $row <= $highestRow; $row++) {

            $ngaySinh = $sheet->getCell('J' . $row)->getValue();
            $ngaySinhFormatted = Carbon::createFromFormat('Y-d-m', $ngaySinh)->format('Y-m-d');


            $phai = $sheet->getCell('E' . $row)->getValue();

            $quyen = $sheet->getCell('K' . $row)->getValue();
            // Kiểm tra xem giá trị 'Phái' có trong mảng ánh xạ không
            $phaiValue = array_key_exists($phai, $genderMappings) ? $genderMappings[$phai] : 0;

            // Kiểm tra xem giá trị 'Quyền' có trong mảng ánh xạ không
            $roleID = array_key_exists($quyen, $roleMappings) ? $roleMappings[$quyen] : 0;

            if (Users::where('UserName', $sheet->getCell('A' . $row)->getValue())->exists()) {
                continue;
            }

            if (Users::where('Email', $sheet->getCell('B' . $row)->getValue())->exists()) {
                continue;
            }

            $usersData[] = [
                'UserName' => $sheet->getCell('A' . $row)->getValue(),
                'Email' => $sheet->getCell('B' . $row)->getValue(),
                'Password' => Hash::make($sheet->getCell('C' . $row)->getValue()),
                'HoTen' => $sheet->getCell('D' . $row)->getValue(),
                'Phai' => $phaiValue,
                'DiaChi' => $sheet->getCell('F' . $row)->getValue(),
                'PhuongXa' => $sheet->getCell('G' . $row)->getValue(),
                'QuanHuyen' => $sheet->getCell('H' . $row)->getValue(),
                'TinhThanh' => $sheet->getCell('I' . $row)->getValue(),
                'NgaySinh' => $ngaySinhFormatted,
                'RoleID' => $roleID,
            ];
        }


        return $usersData;
    }
}
