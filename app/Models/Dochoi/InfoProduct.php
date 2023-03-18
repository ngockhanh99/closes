<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class InfoProduct extends Model
{
    protected $table = 'info_product';
    public $timestamps    = FALSE;
    protected $fillable = [
        'dochoi_san_pham_id',
        'size_id',
        'color_id',
        'quantity',
        "media_id"
    ];
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    }
    public function color(){
        return $this->belongsTo(Mau::class,'color_id');
    }
    public function media(){
        return $this->belongsTo(Cores_Media::class,'media_id');
    }
}