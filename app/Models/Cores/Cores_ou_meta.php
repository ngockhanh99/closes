<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;

class Cores_ou_meta extends Model
{

    protected $primaryKey = 'ou_meta_id';
    public $timestamps = FALSE;
    protected $table = 'cores_ou_metas';

    const _CONST_LOG = 'log'; //Đơn vị Là cha của phòng ban
    const _CONST_EMAIL = 'email'; //email nhận thông báo
    const _CONST_SMS = 'sms'; //Số điện thoại nhận thông báo
    const _CONST_DIRECTOR_NAME = 'director_name'; //Tên giám đốc
    const _CONST_DIRECTOR_PHONE = 'director_phone'; //Số điện thoại giám đốc
    const _CONST_DIRECTOR_EMAIL = 'director_email'; //email giám đốc
    const _CONST_ACCOUNTANT_NAME = 'accountant_name'; //tên kế toán
    const _CONST_ACCOUNTANT_PHONE = 'accountant_phone'; //Số điện thoại kế toán
    const _CONST_ACCOUNTANT_EMAIL = 'accountant_email'; //email kế toán
    const _CONST_HRM_NAME = 'HRM_name'; //tên quản lý
    const _CONST_HRM_PHONE = 'HRM_phone'; //Số điện thoại quản lý
    const _CONST_HRM_EMAIL = 'HRM_email'; //Email quản lý

    public static function makeInstance()
    {
        return new self();
    }

    public function updateOuMeta($v_ou_id, $v_key, $v_value)
    {
        $metaInfo = $this->where([
            ['ou_id', $v_ou_id],
            ['ou_meta_key', $v_key],
        ])->first();
        if (!is_null($metaInfo)) {
            $metaInfo->ou_meta_value = $v_value;
            $metaInfo->save();
        } else {
            $this->insert([
                'ou_id' => $v_ou_id,
                'ou_meta_key' => $v_key,
                'ou_meta_value' => $v_value
            ]);
        }
    }

    public function getOuMeta($v_ou_id, $v_key)
    {
        $meta = $this->where([
            ['ou_id', $v_ou_id],
            ['ou_meta_key', $v_key]
        ])->first();
        return !is_null($meta) ? $meta->ou_meta_value : null;
    }

}
