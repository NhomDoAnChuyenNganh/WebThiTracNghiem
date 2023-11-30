<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDeThi extends Model
{
    use HasFactory;
    
    protected $table = 'chitietdethi';
    protected $primaryKey = ['MaDe', 'MaCH'];
    public $incrementing = false; // Since the primary key is composite
    public $timestamps = false;
    protected $fillable = [
        'MaDe',
        'MaCH',
    ];
    public function dethi()
    {
        return $this->belongsTo(Dethi::class, 'MaDe', 'MaDe');
    }
    public function cauhoi()
    {
        return $this->belongsTo(Cauhoi::class, 'MaCH', 'MaCH');
    }
}
