<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users'; // Tên bảng trong cơ sở dữ liệu

    protected $primaryKey = 'UserID'; // Khóa chính của bảng

 
    protected $fillable = [
        'UserName',
        'Email',
        'Password',
        'HoTen',
        'Phai',
        'DiaChi',
        'NgaySinh',
        'RoleID',
    ];

  
    protected $hidden = [
        'Password', 
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'RoleID', 'RoleID');
    }
}
