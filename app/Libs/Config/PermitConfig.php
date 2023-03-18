<?php

/*
 * Cấu hình danh sách quyền sử dụng
 */

namespace App\Libs\Config;

use Illuminate\Support\Arr;

class PermitConfig
{

    private $arrPermit;

    public function __construct()
    {
        $this->setListPermit();
    }

    private function setListPermit()
    {
        $config = config('parIndex');
        $arrMenu = Arr::get($config, 'menu-left');

        $arrPermit = [];
        foreach ($arrMenu as $menu1){
            $permit1['label'] = $menu1['label'];
            $permit1['permit'] = [];
            foreach ($menu1['permit'] as $key2 => $menu2){
                $permit1['permit'][] = [
                    'code' => $key2,
                    'label' => $menu2['label'],
                ];
                if(!isset($menu2['permit'])){
                    continue;
                }
                foreach ($menu2['permit'] as $key3 => $menu3){
                    $permit1['permit'][] = [
                        'code' => $key3,
                        'label' => $menu3['label'],
                    ];
                }
            }
            $arrPermit[] = $permit1;
        }
        $this->arrPermit = $arrPermit;
    }

    /**
     * lấy danh sách quyền sử dụng
     * @return type
     */
    public function listPermit()
    {
        return $this->arrPermit;
    }

    public function checkPermit($code)
    {
        $retVal = false;
        foreach ($this->arrPermit as $item) {
            if (array_key_exists($code, $item['permit'])) {
                $retVal = true;
                break;
            }
        }
        return $retVal;
    }

    public function listPermitOfArray($data)
    {
        $retVal = [];
        foreach ($this->arrPermit as $item) {
            foreach ($item['permit'] as $permitCode => $permitName) {
                if ($data->contains('permit', $permitCode)) {
                    $retVal[$permitCode] = $permitName;
                }
            }
        }

        return $retVal;
    }

}
