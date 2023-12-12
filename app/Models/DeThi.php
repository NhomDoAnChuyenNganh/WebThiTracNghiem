<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeThi extends Model
{
    protected $table = 'dethi'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'MaDe'; // Khóa chính của bảng

 
    protected $fillable = [
        'TenDeThi',
        'ThoiGianLamBai',
        'NgayThi',
        'ThoiGianBatDau',
        'ThoiGianKetThuc',
        'SoLuongCH',
        'TrangThai',
        'MaGVSD',
        'MaMH',
        'MaCBCT',
        'MaPT', 
    ];
    
    public $timestamps = false;

    public function MonHoc()
    {
        return $this->belongsTo(MonHoc::class, 'MaMH', 'MaMH');
    }
    public function giaoVienSoanDe()
    {
        return $this->belongsTo(Users::class, 'MaGVSD', 'UserID');
    }
    public function canBoCoiThi()
    {
        return $this->belongsTo(Users::class, 'MaCBCT', 'UserID');
    }
    public function phongThi()
    {
        return $this->belongsTo(PhongThi::class, 'MaPT', 'MaPT');
    }
    
}
