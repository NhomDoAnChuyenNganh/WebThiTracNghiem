<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'UserID'; // Khóa chính của bảng

 
    protected $fillable = [
        'UserName',
        'Email',
        'Password',
        'HoTen',
        'Phai',
        'DiaChi',
        'PhuongXa',
        'QuanHuyen',
        'TinhThanh',
        'NgaySinh',
        'RoleID',
        'Token',
        'TimeReset',
    ];
    
    public $timestamps = false;
  
    protected $hidden = [
        'Password', 
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'RoleID', 'RoleID');
    }
    public function thi()
    {
        return $this->hasMany(Thi::class, 'MaSV', 'UserID');
    }
}
