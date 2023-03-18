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
use App\Http\Requests\DistrictRequest;
use App\classHelpers\ReOrder;

class DistrictCtrl extends RestController
{
    /**
     * Lay danh sach tinh thanh
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(Request $request)
    {
        $list_district = Cores_district::makeinstance()->getAll($request->all());
        return response()->json($list_district);
    }

    public function getById(Request $request){
        return Cores_district::find($request->district_id);
    }

    public function getDistrictByProvinceId(Request $request){
        $province_id = $request->province_id;
        $district = Cores_district::whereHas('province',function($query) use($province_id){
            $query->where('id',$province_id);
        })->get();
        return response()->json($district);
    }

    public function insert(DistrictRequest $request){
        $name = $request->name??'';
        $province_id = $request->province_id??'';

        $province = Cores_province::find($province_id);
        if(!$province) return response()->json([
            'errors' => ['province_id'=>['Không tồn tại Tỉnh/Thành Phố này trong cơ sở dữ liệu.']]
        ],422);

        if(Cores_district::checkUniqueName($name,$province_id) != 0){
            return response()->json(['errors' => ['name'=>[$province->name.' đã có Quận/Huyện này.']]],422);
        }
        $parameter = $request->all();
        $district = Cores_district::create($parameter);
        ReOrder::_reorder($district,$district->province_id,'province_id');
        return response()->json($district);
    }

    public function update($id,DistrictRequest $request){
        $district = Cores_district::find($id);
        $province = Cores_province::find($request->province_id);
        if(!$province) return response()->json([
            'errors' => ['province_id'=>['Không tồn tại Tỉnh/Thành Phố này trong cơ sở dữ liệu.']]
        ],422);

        if(($district->name != $request->name) && (Cores_district::checkUniqueName($request->name,$request->province_id) != 0)){
            return response()->json(['errors' => ['name'=>[$province->name.' đã có Quận/Huyện này.']]],422);
        }

        $district->province_id = $request->province_id??'';
        $district->code = $request->code??'';
        $district->name = $request->name??'';
        $district->status = $request->status??'';
        $district->order = $request->order??'';
        $district->save();
        ReOrder::_reorder($district,$district->province_id,'province_id');
        return response()->json($district);
    }

    public function delete($id){
        Cores_district::destroy($id);
        return response()->json('deleted!');
    }
}
