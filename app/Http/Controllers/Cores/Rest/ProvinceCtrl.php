<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Requests\CareerRequest;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_group_meta;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Validator;
use App\Http\Requests\ProvinceRequest;
use App\classHelpers\ReOrder;

class ProvinceCtrl extends RestController
{
    /**
     * Lay danh sach tinh thanh
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $allData = Cores_province::makeinstance()->getAll($request->all());
        return response()->json($allData);
    }

    public function getById(Request $request){
        return Cores_province::find($request->province_id);
    }

    public function insert(ProvinceRequest $request){
        $parameter = $request->all();
        $province = Cores_province::create($parameter);
        ReOrder::_reorder($province);
        return response()->json($province);
    }

    public function update($id,ProvinceRequest $request){
        $province = Cores_province::find($id);
        $province->code = $request->code??'';
        $province->name = $request->name??'';
        $province->status = $request->status??'';
        $province->order = $request->order??'';
        $province->save();
        ReOrder::_reorder($province);

        return response()->json($province);
    }

    public function delete($id){
        Cores_province::destroy($id);
        return response()->json('deleted!');
    }
}
