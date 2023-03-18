<?php

namespace App\Http\Controllers\Cores\Rest;

use \App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermitCtrl extends RestController {

    /**
     * Permit
     * @var type
     */
    private $permit;

    public function __construct()
    {
        $this->permit = app('PermitConfig');
    }

    function getAll()
    {
        $is_admin  = Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $permits = $this->permit->listPermit();
        if(!$is_admin){
            foreach ($permits as &$permit){

                $arr_permit = array();
                foreach ($permit['permit'] as $value){
                    if( isset($value['allowed_grant']) && $value['allowed_grant'] == 1){
                        $arr_permit[] = $value;
                    }
                }
                $permit['permit'] = $arr_permit;
            }
        }
        return response()->json($permits);

    }

}
