<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\Mau;
use Illuminate\Http\Request;

class MauCtrl extends RestController
{
    public function getAll(Request $request){
        $params = $request->all();
        $per_page = $params['per_page']??null;
        $data = Mau::getData($params)->setPaginate($per_page);

        return response()->json($data);
    }

    public function insert(Request $request){
        $params = $request->all();
        $data = Mau::create($params);
        return response()->json($data);
    }

    public function update($id,Request $request){
        $params = $request->all();
        $data = Mau::find($id);
        $data->update($params);
        return response()->json($data);
    }

    public function delete($id){
        Mau::destroy($id);
        return response()->json('deleted!');
    }
}