<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\InfoProduct;
use App\Models\Dochoi\Order;
use App\Models\Dochoi\OrderDraft;
use App\Models\Dochoi\Sanpham;
use App\Models\Dochoi\SanphamFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderCtrl extends RestController
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
        $order = Order::create([
                'user_id'=>Auth::id(),
                'name'=>$request->name??null,
                'phone'=>$request->phone??null,
                'province_id'=>$request->province_id??null,
                'district_id'=>$request->district_id??null,
                'village_id'=>$request->village_id??null,
                "address_reservie"=>$request->address_reservie??null,
                "payment"=>$request->payment??null,
            ]);
        OrderDraft::where('user_id',Auth::id())->where('order_id',0)->update(['order_id' => $order->id]);
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
        $sanpham = Sanpham::find($id);
        $sanpham->delete();
        $sanpham->medias()->sync(null);
        return response()->json($sanpham);
    }
}