<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\User;
use Illuminate\Http\Request;

class MenuCtrl extends RestController
{

    private $asideLeft;

    function __construct()
    {
        $this->asideLeft = app('MenuLeftConfig');

    }


    public function store()
    {
        $user     = new User();
        $arr_menu = $this->asideLeft->listMenuLeft();
        $menu_tmp = [];
        if (is_null($user)) {
            return response()->json($menu_tmp);
        }

        foreach ($arr_menu as &$menu) {
            $show       = false;
            $permit_tmp = [];
            foreach ($menu['permit'] as $key => $permit) {
                if (($user->hasRole($key) && $key != 'mca-chat-realtime') || $key == 'notification' ||
                    ($key == 'mca-chat-realtime' && config('app.CHAT_REALTIME')))
                {
                    $permit_tmp[$key] = $menu['permit'][$key];
                    $show             = true;
                } else if (isset($permit['permit'])) {
                    $showChild        = false;
                    $permit_child_tmp = [];
                    foreach ($permit['permit'] as $keyChild => $permitChild) {
                        if ($user->hasRole($keyChild)) {
                            $permit_child_tmp[$keyChild] = $permit['permit'][$keyChild];
                            $showChild                   = true;
                        } else if (isset($permit['permit'])) {

                        }
                    }
                    if ($showChild) {
                        $show                       = true;
                        $permit_tmp[$key]           = $menu['permit'][$key];
                        $permit_tmp[$key]['permit'] = $permit_child_tmp;
                    }
                }
            }
            if ($show) {
                $menu['permit'] = $permit_tmp;
                $menu_tmp[]     = $menu;
            }
        }
        return response()->json($menu_tmp);
    }

    public function store1()
    {
        $user     = new User();
        $arr_menu = $this->asideLeft->listMenuLeft();
        $menu_tmp = [];
        if (is_null($user))
        {
            return response()->json($menu_tmp);
        }

        foreach ($arr_menu as &$menu)
        {
            $show       = false;
            $permit_tmp = [];
            foreach ($menu['permit'] as $key => $permit)
            {
                if (($user->hasRole($key) && $key != 'mca-chat-realtime') || $key == 'notification' ||
                    ($key == 'mca-chat-realtime' && config('app.CHAT_REALTIME')))
                {
                    $permit_tmp[$key] = $menu['permit'][$key];
                    $show             = true;
                }
            }
            if ($show)
            {
                $menu['permit'] = $permit_tmp;
                $menu_tmp[]     = $menu;
            }
        }
        return response()->json($menu_tmp);
    }

}
