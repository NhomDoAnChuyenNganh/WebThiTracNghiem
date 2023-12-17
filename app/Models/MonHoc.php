<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    use HasFactory;

    protected $table = 'monhoc';
    protected $primaryKey = 'MaMH';
    public $timestamps = false;

    protected $fillable = ['TenMH'];

    public function dsDeThi()
    {
        return $this->hasMany('App\Models\DeThi', 'MaMH', 'MaMH')->whereNull('MaPT');
    }
    public function dsLichThi()
    {
        return $this->hasMany('App\Models\DeThi', 'MaMH', 'MaMH') ->whereNotNull('MaPT') ->where('TrangThai', 0);;
    }
}
