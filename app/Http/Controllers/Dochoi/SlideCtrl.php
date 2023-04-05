<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\Slide;
use Illuminate\Http\Request;

class SlideCtrl extends RestController
{
    public function getAll(Request $request){
        $params = $request->all();
        $per_page = $params['per_page']??null;
        $data = Slide::getData($params)->setPaginate($per_page);

        return response()->json($data);
    }

    public function insert(Request $request){
        $params = $request->all();
        $params['media_id'] = $params['media_id']??0;
        $data = Slide::create($params);
        return response()->json($data);
    }

    public function update($id,Request $request){
        $params = $request->all();
        $params['media_id'] = $params['media_id']??0;
        $data = Slide::find($id);
        $data->update($params);
        return response()->json($data);
    }

    public function delete($id){
        Slide::destroy($id);
        return response()->json('deleted!');
    }
}