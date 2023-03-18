<?php

namespace App\Http\Controllers;

use App\Models\Cores\Cores_province;
use App\Models\Dochoi\Loaisanpham;
use App\Models\Dochoi\OrderDraft;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{

    public function index()
    {

          $order = OrderDraft::with('sanpham.medias','color','size')->where('user_id',Auth::id())->where('order_id',0)->get();
          $province = Cores_province::all();
          $sum = 0;
          foreach($order as $value){
            $sum += $value->sanpham->price*$value->quantity;
          }
          $array_tt=[
            'sum'=>$sum,
            'ship'=>25000,
            'discount' => 25,
            'total' => ($sum* 0.25) - 25000
          ];
          $listloaisanpham = Loaisanpham::all();
        return view('frontend.cart.cart',compact('order','array_tt','province','listloaisanpham'));
    }
}