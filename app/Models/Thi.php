<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thi extends Model
{
    use HasFactory;
    protected $table = 'thi';
    protected $primaryKey = 'MaDe';
    public $timestamps = false;

    protected $fillable = ['MaSV','SoCauDung','Diem'];

    public function deThi()
    {
        return $this->belongsTo(DeThi::class, 'MaDe', 'MaDe');
    }
    public function user()
    {
        return $this->belongsTo(Users::class, 'MaSV', 'UserID');
    }

}
