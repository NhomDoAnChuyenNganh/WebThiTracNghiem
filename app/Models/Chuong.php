<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chuong extends Model
{
    use HasFactory;

    protected $table = 'chuong';
    protected $primaryKey = 'MaChuong';
    public $timestamps = false;

    protected $fillable = ['TenChuong', 'MaMH'];

    public function monhoc()
    {
        return $this->belongsTo(Monhoc::class, 'MaMH', 'MaMH');
    }

}
