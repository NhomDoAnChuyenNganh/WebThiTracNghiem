<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongThi extends Model
{
    protected $table = 'phongthi';
    protected $primaryKey = 'MaPT';
    public $timestamps = false;

    protected $fillable = ['TenPT'];
}
