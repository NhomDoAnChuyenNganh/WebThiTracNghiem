<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeThi extends Model
{
    use HasFactory;
    protected $table = 'dethi'; // Tên của bảng trong cơ sở dữ liệu

    protected $primaryKey = 'MaDe'; // Khóa chính của bảng
    
    public $timestamps = false; // Nếu bạn không sử dụng timestamps

    // Các trường trong bảng
    protected $fillable = [
        'TenDeThi',
        'ThoiGianLamBai',
        'ThoiGianBatDau',
        'ThoiGianKetThuc',
        'SoLuongCH',
        'TrangThai',
        'MaGVSD',
        'MaMH',
        'MaCBCT',
        'MaPT',
    ];

    public function giangVienSoanDe()
    {
        return $this->belongsTo(User::class, 'MaGVSD', 'UserID');
    }

    // Quan hệ khóa ngoại với bảng monhoc
    public function monHoc()
    {
        return $this->belongsTo(MonHoc::class, 'MaMH', 'MaMH');
    }

    // Quan hệ khóa ngoại với bảng users (cán bộ coi thi)
    public function canBoCoiThi()
    {
        return $this->belongsTo(User::class, 'MaCBCT', 'UserID');
    }

    // Quan hệ khóa ngoại với bảng phongthi
    public function phongThi()
    {
        return $this->belongsTo(PhongThi::class, 'MaPT', 'MaPT');
    }
}
