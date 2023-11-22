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
}
