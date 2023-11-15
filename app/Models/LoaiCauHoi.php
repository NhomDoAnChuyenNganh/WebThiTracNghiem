<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiCauHoi extends Model
{
    use HasFactory;

    protected $table = 'loaicauhoi';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false; // Nếu bạn không sử dụng timestamps
    protected $fillable = ['TenLoai'];
    public function cauhoi()
    {
        return $this->hasMany(CauHoi::class , 'MaLoai', 'MaLoai');
    }
}
