<?php
namespace App\Http\Controllers\Dochoi;

use App\Http\Controllers\RestController;
use App\Models\Dochoi\Dashboard;
use Illuminate\Http\Request;

class DashboardCtrl extends RestController
{
    public function getAll(Request $request){
        $dashboard=Dashboard::first();
        return response()->json($dashboard);
    }

    public function update(Request $request){
        $params = $request->all();
        $count=Dashboard::count();
        if($count>0){
            Dashboard::first()->update([
                'address'=>$params['address']??null,
                'phone'=>$params['phone']??null,
                'email'=>$params['email']??null,
                'facebook'=>$params['facebook']??null,
                'zalo'=>$params['zalo']??null,
                'instagram'=>$params['instagram']??null,
            ]);
        }else{
            Dashboard::create([
                'address'=>$params['address']??null,
                'phone'=>$params['phone']??null,
                'email'=>$params['email']??null,
                'facebook'=>$params['facebook']??null,
                'zalo'=>$params['zalo']??null,
                'instagram'=>$params['instagram']??null,

            ]);
        }
        return response()->json();
    }

}