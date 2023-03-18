<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;

class Cores_user_meta extends Model
{

    protected $table      = 'cores_user_metas';
    protected $primaryKey = 'user_meta_id';
    public $timestamps    = FALSE;

    const _CONST_OU_PARENT    = 'OU_PARENT'; //NSD trực thuộc đơn vị
    const _CONST_GROUP_PARENT = 'GROUP_PARENT'; //NSD trực thuộc nhóm người sử dụng
    #Quyền
    const _CONST_PERMIT       = 'permit'; //quyền

    ##Danh sách key user info
    const _CONST_JOB_TITLE    = 'user_job_title'; //chức danh
    const _CONST_ADDRESS      = 'user_address'; //địa chỉ
    const _CONST_PHONE        = 'user_phone'; //số điện thoại

    const _PERSONAL_NAME = 'personal_name'; //Họ tên cá nhân
    const _ENTERPRISE_WEBSITE = 'enterprise_website'; //Địa chỉ website của cơ quan/tổ chức

    static function makeInstance()
    {
        return new self();
    }

    function getAllKeyUserInfo()
    {
        return [
            self::_CONST_JOB_TITLE,
            self::_CONST_ADDRESS,
            self::_CONST_PHONE,
            self::_PERSONAL_NAME,
            self::_ENTERPRISE_WEBSITE,
        ];
    }

    /**
     * Lưu thông tin cá nhân người sử dụng
     * @param type $user_id
     * @param type $arrInfo
     */
    public function updateUserInfo($user_id, $arrInfo)
    {
        if ($user_id)
        {
            foreach ($this->getAllKeyUserInfo() as $key)
            {
                $metaInfo = $this->where([
                            ['user_id', $user_id],
                            ['user_meta_key', '=', $key]
                        ])->first();
                $value = $arrInfo[$key] ?? '';
                if (!is_null($metaInfo))
                {
                    $metaInfo->user_meta_value = $value;
                    $metaInfo->save();
                }
                else
                {
                    $this->insert([
                        'user_id'         => $user_id,
                        'user_meta_key'   => $key,
                        'user_meta_value' => $value
                    ]);
                }
            }
        }
    }

    /**
     *
     * @param type $user_id
     * @param array $data
     * @param type $key
     */
    function updateByMetaKey($user_id, array $data = [], $key)
    {
        // dd($user_id, $data);
        if ($user_id)
        {
            $this->where([
                        ['user_id', $user_id],
                        ['user_meta_key', '=', $key]
                    ])
                    ->whereNotIn('user_meta_value', $data)
                    ->delete();

            foreach ($data as $item)
            {
                $count = $this->where([
                            ['user_id', $user_id],
                            ['user_meta_key', '=', $key],
                            ['user_meta_value', '=', $item]
                        ])->count();
                if ((int) $count == 0)
                {
                    $this->insert([
                        'user_id'         => $user_id,
                        'user_meta_key'   => $key,
                        'user_meta_value' => $item
                    ]);
                }
            }
        }
    }
     /**
     * Cập nhật danh sách nsd thuộc nhóm nsd
     * @param type $group_id
     * @param array $data
     * @param type $key
     */
    function updateGroupParentByMetaKey($group_id, array $data = [])
    {
        if ($group_id)
        {
            $this->where([
                        ['user_meta_value', $group_id],
                        ['user_meta_key', '=', self::_CONST_GROUP_PARENT]
                    ])
                    ->whereNotIn('user_id', $data)
                    ->delete();
            foreach ($data as $item)
            {
                $count = $this->where([
                            ['user_id', $item],
                            ['user_meta_key', '=', self::_CONST_GROUP_PARENT],
                            ['user_meta_value', '=', $group_id]
                        ])->count();
                if ((int) $count == 0)
                {
                    $this->insert([
                        'user_id'         => $item,
                        'user_meta_key'   => self::_CONST_GROUP_PARENT,
                        'user_meta_value' => $group_id
                    ]);
                }
            }
        }
    }

}
