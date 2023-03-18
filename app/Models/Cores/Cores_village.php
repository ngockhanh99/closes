<?php

namespace App\Models\Cores;


use Illuminate\Database\Eloquent\Model;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Support\Facades\Auth;

class Cores_village extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = FALSE;
    protected $table = 'cores_village';
    protected $fillable = [
        'district_id',
        'code',
        'name',
        'status',
        'order'
    ];

    static function makeinstance()
    {
        return new self();
    }
    public function district(){
        return $this->belongsTo(Cores_district::class,'district_id','id');
    }
    function scopeFillterKeyword($query, $keyword)
    {
        if(trim($keyword)!==''){
            return $query->where('name','like',"%$keyword%");
        }
        return $query;
    }

    function scopeFillterStatus($query, $status)
    {
        if ($status !== null) {
            $status = $status ? 1 : 0;
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeOrderByCol($query, $order_col = null, $direction = 'asc')
    {
        $direction = $direction === 'desc' ? 'desc' : 'asc';
        $arr_col = ['id', 'name', 'order'];
        $order_col = in_array($order_col, $arr_col) ? $order_col : '';
        if (!empty($order_col)) {
            return $query->orderBy($order_col, $direction);
        }
        return $query->orderBy('id', $direction);
    }

    public function scopeGetOrPaginate($query, $limit)
    {
        if ((int)$limit < 1) {
            return $query->get();
        }
        return $query->paginate($limit);
    }
    public static function checkUniqueName($name,$district_id){
        return self::whereHas('district', function($query) use($district_id){
                $query->where('id',$district_id);
            })->where('name',$name)
            ->get()->count();
    }
    function getAll($params)
    {
        $v_keyword = $params['keyword'] ?? '';
        $v_status = $params['status'] ?? null;
        $v_order_col = $params['order_col'] ?? 'name';
        $v_direction = $params['direction'] ?? 'asc';
        $v_limit = $params['limit'] ?? 0;

        return $this->with('district')
        ->orderBy('district_id')
        ->orderBy('order')
        ->fillterKeyword($v_keyword)
            ->fillterStatus($v_status)
            ->orderByCol($v_order_col, $v_direction)
            ->getOrPaginate($v_limit);
    }
}
