<?php

/*
 * Cấu hình danh sách quyền sử dụng
 */

namespace App\Libs\Config;

use Illuminate\Support\Arr;

class TypeXHHConfig
{

    private $arrTypeXHH;

    public function __construct()
    {
        $config          = config('parIndex');
        $this->arrTypeXHH = Arr::get($config, 'type-xhh');
    }

    /**
     * lấy danh sách quyền sử dụng
     * @return type
     */
    public function listTypeXHH()
    {
        $retVal = $this->arrTypeXHH;
        return $retVal;
    }
}
