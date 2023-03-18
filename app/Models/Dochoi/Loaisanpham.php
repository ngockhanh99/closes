<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Loaisanpham extends Model
{
    protected $table = 'dochoi_loai_san_pham';
    protected $fillable = [
        'name',
        'status',
        'dochoi_danhmuc_id',
        'media_id'
    ];
    public function media(){
        return $this->belongsTo(Cores_Media::class,'media_id');
    }
    public function danhmuc(){
        return $this->belongsTo(Danhmuc::class,'dochoi_danhmuc_id');
    }
    public function scopeFilterByKeyWord($query,$key_word){
        if(trim($key_word) != ''){
            return $query->where('name','like',"%{$key_word}%");
        }
        return $query;
    }
    public function scopeSetPaginate($query,$per_page){
        if(isset($per_page)){
            return $query->paginate($per_page);
        }
        return $query->get();
    }

    public static function getData($params){
        $key_word = $params['key_word']??'';
        $unit = new self();
        return $unit->with('media','danhmuc')->filterByKeyWord($key_word);
    }
}