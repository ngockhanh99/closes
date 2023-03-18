<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\Cores\Cores_village;
use App\Models\Cores\Cores_district;
use Illuminate\Http\Request;
use App\Http\Requests\VillageRequest;
use App\Http\Controllers\RestController;
use Validator;
use App\classHelpers\ReOrder;

class VillageCtrl extends RestController
{
    /**
     * Lay danh sach tinh thanh
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getAll(Request $request)
    {
       
        $allData = Cores_village::makeinstance()->getAll($request->all());
       
        return response()->json($allData);
    }

    public function getDistrictByDistrictId(Request $request){
        $district_id = $request->district_id;
        $village = Cores_village::whereHas('district',function($query) use($district_id){
            $query->where('id',$district_id);
        })->get();
        return response()->json($village);
    }

    public function insert(VillageRequest $request){
        $name = $request->name??'';
        $district_id = $request->district_id??'';

        $district = Cores_district::find($district_id);
        if(!$district) return response()->json([
            'errors' => ['district_id'=>['Không tồn tại Quận/Huyện này trong cơ sở dữ liệu.']]
        ],422);

        if(Cores_village::checkUniqueName($name,$district_id) != 0){
            return response()->json(['errors' => ['name'=>[$district->name.' đã có Phường/Xã này.']]],422);
        }
        $parameter = $request->all();
        $village = Cores_village::create($parameter);
        ReOrder::_reorder($village,$village->district_id,"district_id");
        return response()->json($village);
    }

    public function update($id,VillageRequest $request){
        $village = Cores_village :: find($id);
        $district = Cores_district::find($request->district_id);
        if(!$district) return response()->json([
            'errors' => ['district_id'=>['Không tồn tại Quận/Huyện này trong cơ sở dữ liệu.']]
        ],422);

        if(($village->name != $request->name) && (Cores_village::checkUniqueName($request->name,$request->district_id) != 0)){
            return response()->json(['errors' => ['name'=>[$village->name.' đã có Phường/Xã này.']]],422);
        }

        $village->district_id = $request->district_id??'';
        $village->code = $request->code??'';
        $village->name = $request->name??'';
        $village->status = $request->status??'';
        $village->order = $request->order??'';
        $village->save();
        ReOrder::_reorder($village,$village->district_id,"district_id");

        return response()->json($village);
    }
    public function delete($id){
        Cores_village::destroy($id);
        return response()->json('deleted!');
    }
}
