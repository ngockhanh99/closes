<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slide';
    protected $fillable = [
        'title',
        'is_banner',
        'media_id',
        'link'
    ];
    public function media(){
        return $this->belongsTo(Cores_Media::class,'media_id');
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
        return $unit->with('media')->filterByKeyWord($key_word);
    }
}