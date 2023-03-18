<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;

class Cores_options extends Model
{
    protected $primaryKey = 'option_id';
    public $timestamps = FALSE;
    protected $table = 'cores_options';

    const _CONST_SITE = 'site'; // site
    const _CONST_CHANGE_PASSWORD = 'CHANGE_PASSWORD'; // Cho phép thay đổi mật khẩu
    const _CONST_SHOW_HELP = 'SHOW_HELP'; // Hiển thị trợ giúp
    const _CONST_AUTO_INDEX_SIPAS = 'AUTO_INDEX_SIPAS'; // tự động tăng số thứ tự
    const _CONST_ORDER_BY_INDEX_SIPAS = 'ORDER_BY_INDEX_SIPAS'; // Sắp xếp mẫu phiếu theo mẫu phiếu
    const _CONST_SEND_LIST_EMAIL = 'SEND_LIST_EMAIL'; // Gửi danh sách email của đơn vị
    const _CONST_APP_FULL_NAME = 'APP_FULL_NAME'; //Tên phần mềm
    const _CONST_UNIT_NAME = 'UNIT_NAME'; //Tên đơn vị
    const _CONST_FOOTER_UNIT = 'FOOTER_UNIT'; //Đơn vị quản lý "Footer"
    const _CONST_FOOTER_ADDRESS = 'FOOTER_ADDRESS'; //Địa chỉ "Footer"
    const _CONST_FOOTER_PHONE = 'FOOTER_PHONE'; //Số điện thoại "Footer"
    const _CONST_FOOTER_EMAIL = 'FOOTER_EMAIL'; //Email "Footer"
    const _CONST_SIPAS_ONLINE_CHECK_TOKEN = 'SIPAS_ONLINE_CHECK_TOKEN'; //Kiểm tra token
    const _CONST_SIPAS_ONLINE_CHECK_IP = 'SIPAS_ONLINE_CHECK_IP'; //Kiểm tra IP
    const _CONST_SIPAS_ONLINE_DAY_IP = 'SIPAS_ONLINE_DAY_IP'; //Kiểm tra IP trong khoảng bao ngày
    const _CONST_SIPAS_ONLINE_IP_FEW_MAX = 'SIPAS_ONLINE_IP_FEW_MAX'; //Số lần ip nhận tối đa sẽ check capcha mức 1
    const _CONST_SIPAS_ONLINE_IP_MUCH_MAX = 'SIPAS_ONLINE_IP_MUCH_MAX'; //Số lần IP nhận tối đa sẽ check capcha mức 2
    const _CONST_SIPAS_ONLINE_IP_MAX = 'SIPAS_ONLINE_IP_MAX'; //Số lần ip nhận tối đa sẽ chặn IP
    const _CONST_PORTAL_ARTICLE = 'PORTAL_ARTICLE'; //Số tin bài nổi bật hiển thị
    const _CONST_PORTAL_DOC = 'PORTAL_DOC'; //Số văn bản hiển thị
    const _CONST_PORTAL_EXPERIENTIAL_TRONG_NUOC = 'PORTAL_EXPERIENTIAL_TRONG_NUOC'; //Số mô hình/kinh nghiệm trong nước hiển thị
    const _CONST_PORTAL_EXPERIENTIAL_QUOC_TE = 'PORTAL_EXPERIENTIAL_QUOC_TE'; //Số mô hình/kinh nghiệm quốc tế hiển thị
    const _CONST_PORTAL_DRAFT = 'PORTAL_DRAFT'; //Số văn bản đang được xin ý kiến hiển thị
    const _CONST_PORTAL_DRAFT_ALREADY = 'PORTAL_DRAFT_ALREADY'; //Số văn bản đã được xin ý kiến hiển thị
    const _CONST_PORTAL_QUESTION = 'PORTAL_QUESTION'; //Số hỏi đáp hiển thị

    public static function makeInstance()
    {
        return new self();
    }

    public function getAll()
    {
        $data = $this::get();
        $options = [];
        foreach ($data as $val) {
            $options[$val->option_name] = $val->option_value;
        }
        return [
            $this::_CONST_SITE => $this->getValue($options, $this::_CONST_SITE),
            $this::_CONST_CHANGE_PASSWORD => $this->getValue($options, $this::_CONST_CHANGE_PASSWORD) ? true : false,
        ];
    }

    private function getValue($options, $code, $default = '')
    {
        return isset($options[$code]) ? $options[$code] : $default;
    }

    public static function getSingle($code)
    {
        $singleInfo = self::where('option_name', $code)->first();
        return isset($singleInfo->option_value) ? $singleInfo->option_value : '';
    }

    function insertOrUpdate($code, $val)
    {
        $singleInfo = $this->where('option_name', $code)->first();
        if (is_null($singleInfo)) {
            $this->insert([
                'option_name' => $code,
                'option_value' => $val
            ]);

        } else {
            $singleInfo->option_value = $val;
            $singleInfo->save();
        }
    }

}
