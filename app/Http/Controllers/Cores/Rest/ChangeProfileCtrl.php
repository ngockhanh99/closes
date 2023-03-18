<?php
namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ChangeProfileCtrl extends RestController
{
    public function getUser(){
        $getUser = Cores_user::with('userMeta')->find(Auth::id());
        return response()->json($getUser);
    }

    public function updateUser(Request $request){
        $params = $request->all();
        $rule = [
            'user_name' => 'required|min:3|max:255',
            'password' => 'nullable|min:5|max:255|alpha_dash',
            'user_avatar' => 'nullable',
            'address' => 'required|min:3',
            'province_id' => 'required|exists:cores_province,id',
            'district_id' => 'required|exists:cores_district,id',
            'village_id' => 'required|exists:cores_village,id',
            'type_id' => 'required|exists:mca_type,id',
            'spec_id' => 'required|exists:mca_spec,id',
            'enterprise_website' => 'nullable|max:255|url',
        ];

        if(!empty($request->password)){
            $rule['password_confirmation'] = 'required|same:password|alpha_dash';
        }

        $validator = Validator::make($params, $rule);
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $update_data = [
            'user_name' => $params['user_name'],
            'province_id' => $params['province_id'],
            'district_id' => $params['district_id'],
            'village_id' => $params['village_id'],
            'type_id' => $params['type_id'],
            'spec_id' => $params['spec_id'],
        ];
        $update_meta = [
            'user_job_title' => $params['job']??'',
            'user_address' => $params['address']??'',
            'personal_name' => $params['personal_name']??'',
            'enterprise_website' => $params['enterprise_website']??'',
        ];

        if(isset($params['password'])){
            $update_data = array_merge($update_data,['password' => bcrypt($params['password'])]);
        }

        $user = Cores_user::find(Auth::id());
        $user->update($update_data);

        $user_meta = new Cores_user_meta();
        $user_meta->updateUserInfo($user->id,$update_meta);

        return response()->json($user);
    }

    public function changeAvatar(Request $request){
        $file = $request->file('file');
        if(!$file) return response()->json(['error' => 'File empty!']);

        $extension = $file->getClientOriginalExtension();
        $path = $request->file('file')->storeAs('public/user_avatar',Str::random(40).'.'.$extension);
        $path = str_replace('public','storage',$path);

        Cores_user::find(Auth::id())->update(['user_avatar' => $path]);

        return response()->json($path);
    }
}
