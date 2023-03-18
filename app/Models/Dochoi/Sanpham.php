<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    protected $table = 'dochoi_san_pham';
    protected $fillable = [
        'name',
        'code',
        'price',
        'quantity',
        'view',
        'description',
        'description_detail',
        'dochoi_loai_san_pham_id',
        'dochoi_do_tuoi_id'
    ];
    public function loaisanpham(){
        return $this->belongsTo(Loaisanpham::class,'dochoi_loai_san_pham_id','id');
    }
    public function infoProduct(){
        return $this->hasMany(InfoProduct::class,'dochoi_san_pham_id');
    }
    public function medias(){
        return $this->belongsToMany(Cores_Media::class,'dochoi_san_pham_file','dochoi_san_pham_id','media_id');
    }

    public function scopeFilterByKeyWord($query,$key_word){
        if(trim($key_word) != ''){
            return $query->where('name','like',"%{$key_word}%");
        }
        return $query;
    }

    public function scopeFilterByLoaisanpham($query, $dochoi_loai_san_pham_id){
        if($dochoi_loai_san_pham_id){
            return $query->where('dochoi_loai_san_pham_id', $dochoi_loai_san_pham_id);
        }
        return $query;
    }

    public function scopeSetPaginate($query, $per_page){
        if(isset($per_page)){
            return $query->paginate($per_page);
        }
        return $query->get();
    }

    public static function getData($params){
        $key_word = $params['key_word']??'';
        $per_page = $params['per_page']??null;
        $sanpham = new self();
        return $sanpham->with(['loaisanpham.danhmuc','medias','infoProduct'=>function($q){
            $q->with('size','color','media');
        }])->filterByKeyWord($key_word)->orderBy('created_at', 'desc')->setPaginate($per_page);
    }
}