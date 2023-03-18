<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\Mau;
use App\Models\Dochoi\Size;
use Illuminate\Http\Request;

class SizeCtrl extends RestController
{
    public function getAll(Request $request){
        $data = Size::all();

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