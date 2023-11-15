<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoanVan extends Model
{
    use HasFactory;

    protected $table = 'doanvan'; 

    protected $primaryKey = 'MaDV'; 

    protected $fillable = ['TenDV', 'MaChuong'];

    public function chuong()
    {
        return $this->belongsTo(Chuong::class, 'MaChuong', 'MaChuong');
    }
    public $timestamps = false;
}
