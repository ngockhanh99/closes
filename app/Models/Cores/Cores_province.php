<?php

namespace App\Models\Cores;


use Illuminate\Database\Eloquent\Model;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Support\Facades\Auth;

class Cores_province extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = FALSE;
    protected $table = 'cores_province';
    protected $fillable = [
        'code',
        'name',
        'status',
        'order'
    ];

    const STATUS_ACTIVE = 1;

    static function makeinstance()
    {
        return new self();
    }

    function scopeFillterKeyword($query, $keyword)
    {
        if (trim($keyword) !== '') {
            return $query->where('name', 'like', "%$keyword%");
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

    function getAll($params)
    {
        $v_keyword = $params['keyword'] ?? '';
        $v_status = $params['status'] ?? null;
        $v_order_col = $params['order_col'] ?? 'name';
        $v_direction = $params['direction'] ?? 'asc';
        $v_limit = $params['limit'] ?? 0;

        return $this->orderBy('order')
            ->fillterKeyword($v_keyword)
            ->fillterStatus($v_status)
            ->orderByCol($v_order_col, $v_direction)
            ->getOrPaginate($v_limit);
    }
}
