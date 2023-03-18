<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class OrderDraft extends Model
{
    protected $table = 'order_draft';
    public $timestamps    = TRUE;
    protected $fillable = [
        'user_id',
        'dochoi_san_pham_id',
        'size_id',
        'color_id',
        'quantity',
        'order_id'
    ];
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function color(){
        return $this->belongsTo(Mau::class,'color_id');
    }
    public function sanpham(){
        return $this->belongsTo(Sanpham::class,'dochoi_san_pham_id');
    }
}