<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps    = TRUE;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'village_id',
        'address',
        'payment',

    ];
    static function makeinstance()
    {
        return new self();
    }
    public function orderDraft(){
        return $this->hasMany(OrderDraft::class,'order_id','id');
    }
    function scopeFillterKeyword($query, $keyword)
    {
        if (trim($keyword) !== '') {
            return $query->where('name', 'like', "%$keyword%");
        }
        return $query;
    }

    public function scopeGetOrPaginate($query, $limit)
    {
        if ((int)$limit < 1) {
            return $query->get();
        }
        return $query->paginate($limit);
    }

    function getAll($params)
    {
        $v_keyword = $params['key_word'] ?? '';
        $v_limit = $params['limit'] ?? 0;
        return self::with(['orderDraft'=>function($q){
            $q->with('size','color','sanpham.medias');
        }])->fillterKeyword($v_keyword)
            ->getOrPaginate($v_limit);
    }
}