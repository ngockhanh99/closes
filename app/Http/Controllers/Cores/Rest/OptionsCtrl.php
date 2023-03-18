<?php

namespace App\Http\Controllers\Cores\Rest;

use \App\Http\Controllers\RestController;
use App\Models\Cores\Cores_options;
use Illuminate\Http\Request;

class OptionsCtrl extends RestController
{
    function getAll()
    {
        $data = Cores_options::makeInstance()->getAll();
        return response()->json($data);
    }

    function update(Request $request)
    {
        $data    = $request->all();
        $options = Cores_options::makeInstance()->getAll();
        foreach ($data as $key => $val) {
            if (isset($options[$key])) {
                Cores_options::makeInstance()->insertOrUpdate($key, $val);
            }
        }
        return response()->json([]);
    }

}
