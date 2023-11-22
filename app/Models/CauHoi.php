<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    use HasFactory;

    protected $table = 'cauhoi';
    protected $primaryKey = 'MaCH';
    public $timestamps = false;
    protected $fillable = ['NoiDung', 'MaDV', 'MaLoai', 'MucDo'];

    public function doanvan()
    {
        return $this->belongsTo(DoanVan::class, 'MaDV', 'MaDV');
    }

    public function loaicauhoi()
    {
        return $this->belongsTo(LoaiCauHoi::class, 'MaLoai', 'MaLoai');
    }

    public function dapan()
    {
        return $this->hasMany(DapAn::class, 'MaCH', 'MaCH');
    }
}
