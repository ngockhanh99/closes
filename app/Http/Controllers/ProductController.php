<?php

namespace App\Http\Controllers;

use App\Models\Dochoi\InfoProduct;
use App\Models\Dochoi\Loaisanpham;
use App\Models\Dochoi\Mau;
use App\Models\Dochoi\OrderDraft;
use App\Models\Dochoi\Sanpham;
use App\Models\Dochoi\Size;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{

    public function index($id)
    {
        $sanpham = Sanpham::with('medias','infoProduct','loaisanpham.danhmuc')->find($id);
        $listsanpham = Sanpham::where('dochoi_loai_san_pham_id',$sanpham->dochoi_loai_san_pham_id)->where('id','<>',$id)->with('medias','infoProduct','loaisanpham.danhmuc')->get();
        $info_product = InfoProduct::where('dochoi_san_pham_id',$id);
        $size = clone $info_product ->select('size_id')->distinct()->pluck('size_id');
        $color = clone $info_product ->select('color_id')->distinct()->pluck('color_id');
        $size = Size::whereIn('id', $size)->get();
        $color = Mau::with('media')->whereIn('id', $color)->get();
        $sanpham->description = json_decode($sanpham->description??'');
        $sanpham->description_detail = json_decode($sanpham->description_detail??'');
        $order = OrderDraft::where('user_id',Auth::id())->where('order_id',0)->get();
        $listloaisanpham = Loaisanpham::all();
        return view('frontend.product.product',compact('sanpham','size','color','listsanpham','order','listloaisanpham'));
    }
    public function listProduct($id,Request $request)
    {
        $order = OrderDraft::where('user_id',Auth::id())->where('order_id',0)->get();
        $listsanpham = Sanpham::where('dochoi_loai_san_pham_id',$id)->with('medias','infoProduct','loaisanpham.danhmuc')->get();
        $listloaisanpham = Loaisanpham::all();
        return view('frontend.product.list_product',compact('listsanpham','order','listloaisanpham'));
    }
}