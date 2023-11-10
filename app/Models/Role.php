<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'RoleID'; // Khóa chính của bảng

    protected $fillable = ['RoleName'];
}
