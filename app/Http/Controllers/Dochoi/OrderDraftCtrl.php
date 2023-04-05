<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\InfoProduct;
use App\Models\Dochoi\OrderDraft;
use App\Models\Dochoi\Sanpham;
use App\Models\Dochoi\SanphamFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDraftCtrl extends RestController
{
    public function getAll(Request $request){
        $params = $request->all();
        $sanpham = Sanpham::getData($params);
        foreach($sanpham as $value){
            $value->description = json_decode($value->description??'');
            $value->description_detail = json_decode($value->description_detail??'');
        }
        return response()->json($sanpham);
    }

    public function insert(Request $request){
        $quantity = $request->quantity??"";
        $order = OrderDraft::where([
            ['dochoi_san_pham_id',$request->san_pham_id],
            ['user_id',Auth::id()],
            ['size_id',$request->size_id],
            ['color_id',$request->color_id],
        ])->first();
        if($order){
            $quantity +=$order->quantity;
            $order->quantity = $quantity;
            $order->save();
        }else{
            OrderDraft::create([
                'user_id'=>Auth::id(),
                'dochoi_san_pham_id'=>$request->san_pham_id??null,
                'size_id'=>$request->size_id??null,
                'color_id'=>$request->color_id??null,
                "quantity"=>$quantity,
            ]);
        }
        return response()->json([]);
    }

    public function update($id,Request $request){
        $params = $request->all(); 
        $params['description'] = json_encode($params['description']??"");
        $params['description_detail'] = json_encode($params['description_detail']??"");
        $sanpham = Sanpham::find($id)??'';
        $sanpham->update($params);
        InfoProduct::where('dochoi_san_pham_id',$sanpham->id)->delete();
        foreach($params['info_product'] as $value){
            InfoProduct::create([
                'media_id'=>$value['media_id'],
                'dochoi_san_pham_id'=>$sanpham->id,
                'size_id'=>$value['size_id'],
                "quantity"=>$value['quantity'],
                'color_id'=>$value['color_id'],
            ]);
        }
        SanphamFile::where('dochoi_san_pham_id',$id)->delete();
        foreach($params['medias'] as $media){
            SanphamFile::create([
                'media_id'=>$media['id'],
                'dochoi_san_pham_id'=>$id
            ]);
        }
        return response()->json($sanpham);
    }
    public function delete($id){
        $order = OrderDraft::find($id);
        $order->delete();
        return response()->json();
    }
}