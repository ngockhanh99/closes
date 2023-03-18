<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\Danhmuc;
use Illuminate\Http\Request;

class DanhmucCtrl extends RestController
{
    public function getAll(Request $request){
        $params = $request->all();
        $per_page = $params['per_page']??null;
        $data = Danhmuc::getData($params)->setPaginate($per_page);

        return response()->json($data);
    }

    public function insert(Request $request){
        $params = $request->all();
        $params['media_id'] = $params['media_id']??0;
        $data = Danhmuc::create($params);
        return response()->json($data);
    }

    public function update($id,Request $request){
        $params = $request->all();
        $params['media_id'] = $params['media_id']??0;
        $data = Danhmuc::find($id);
        $data->update($params);
        return response()->json($data);
    }

    public function delete($id){
        Danhmuc::destroy($id);
        return response()->json('deleted!');
    }
}