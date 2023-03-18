<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\CalculationFormulaDetailModel;
use App\Models\CalculationFormulaModel;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_group;
use App\Models\Cores\Cores_ou;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_group_meta;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_village;
use App\Models\MCA\SpecModel;
use App\Models\MCA\TypeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Requests\GroupRequest;

class CatalogCtrl extends RestController
{

    function getAll()
    {
        $data = [];
        $data['enterpriseTypes'] = TypeModel::makeinstance()->getAll(['status' => 1]);
        $data['carrers'] = SpecModel::makeinstance()->getAll(['status' => 1]);

        $data['provinces'] = Cores_province::makeinstance()->getAll(['status' => 1]);
        $data['district'] = Cores_district::makeinstance()->getAll(['status' => 1]);
        $data['villages'] = Cores_village::makeinstance()->getAll(['status' => 1]);
        $data['arr_status'] = Cores_ou::makeInstance()->get_ou_status();
        return response()->json($data);
    }

}
