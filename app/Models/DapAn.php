<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DapAn extends Model
{
    use HasFactory;
    
    protected $table = 'dapan';
    protected $primaryKey = 'MaDA';
    public $timestamps = false; // Nếu bạn không sử dụng timestamps
    protected $fillable = ['NoiDungDapAn', 'LaDapAnDung','MaCH'];
    public function cauhoi()
    {
        return $this->belongsTo(CauHoi::class, 'MaCH', 'MaCH');
    }

}
