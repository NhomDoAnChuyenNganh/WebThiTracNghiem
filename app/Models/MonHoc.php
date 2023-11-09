<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $table = 'monhoc';
    protected $primaryKey = 'MaMH';
    public $timestamps = false;

    protected $fillable = ['TenMH'];
    use HasFactory;
}
