<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauTao extends Model
{
    use HasFactory;
    protected $table = 'cautao';
    protected $primaryKey = 'MaDe';
    public $timestamps = false;
    protected $fillable = [
        'MaDe',
        'MaChuong',
        'SoLuongGioi',
        'SoLuongKha',
        'SoLuongTB',
        'SoLuongCH'
        // Thêm các trường khác nếu cần
    ];
    // Một đề thi có nhiều câu hỏi cần cấu tạo
    public function dethi()
    {
        return $this->belongsTo(Dethi::class, 'MaDe', 'MaDe');
    }
    // Một chương có thể thuộc nhiều đề thi được cấu tạo
    public function chuong()
    {
        return $this->belongsTo(Chuong::class, 'MaChuong', 'MaChuong');
    }
}
