<?php

namespace App\Http\Controllers;

use App\Models\Cores\Cores_province;
use App\Models\Dochoi\Dashboard;
use App\Models\Dochoi\Loaisanpham;
use App\Models\Dochoi\OrderDraft;
use App\Models\Dochoi\Sanpham;
use App\Models\Dochoi\Slide;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends BaseController
{

    public function index()
    {
        $loaisanpham =  Loaisanpham::with('media')->get();
        $sanpham =  Sanpham::with('medias')->limit(8)->orderBy('id','desc')->get();
        $dashboard=Dashboard::first();
        $order = OrderDraft::where('user_id',Auth::id())->where('order_id',0)->get();
        $slides = Slide::all();
        // end menu right
        return view('frontend.index', compact('loaisanpham','sanpham',"order",'dashboard','slides'));
    }
}