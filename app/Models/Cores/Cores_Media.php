<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;

class Cores_Media extends Model
{

    protected $table   = 'cores_media';
    protected $primary = 'id';
    
    protected $fillable = [
        'filename',
        'filepath',
        'file_ext',
        'user_id'
    ];

    /**
     * Lấy danh sách file đính kèm
     * @param boolean $is_admin true trả về toàn bộ files; lấy theo người sử dụng người tạo
     * @param int||null $v_user_id
     * @return array
     */
    function allFiles($is_admin = false, $v_user_id = null, $year = null)
    {
        $instance = $this;
        if (!$is_admin)
        {
            $instance = $instance->where('user_id', $v_user_id);
        }
        if (!empty($year))
        {
            $instance = $instance->whereRaw('DATE_FORMAT(cores_media.created_at,"%Y") = ?', $year);
        }
        return $instance
                        ->leftjoin('users', 'users.id', '=', 'cores_media.user_id')
                        ->orderBy('id', 'desc')
                        ->select('cores_media.*', 'users.user_name')
                        ->paginate(5)
                        ->toArray();
    }

    function allYear($is_admin, $v_user_id)
    {
        $instance = $this;
        if (!$is_admin)
        {
            $instance = $instance->where('user_id', $v_user_id);
        }
        return $instance->select(\DB::raw('DATE_FORMAT(created_at,"%Y") as year '))
                        ->groupBy('year')
                        ->pluck('year');
    }

}
