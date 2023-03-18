<?php
namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\classHelpers\ReOrder;
use App\Http\Requests\MCAUserRequest;

class MCAUserCtrl extends RestController
{
    public function getListUser(){
        $isAdmin = Auth::user()->user_is_admin;
        $permits = app('PermitConfig')->listPermit();
        $listRole = Cores_user::LIST_ROLE;
        $users = Cores_user::with('userMeta');
        if(!$isAdmin){
            $users = $users->where('id',Auth::id());
        }
        $users = $users->get();
        return response()->json(['listUser'=>$users,'listRole'=>$listRole,'listPermit'=>$permits]);
    }

    public function insertUser(MCAUserRequest $request)
    {
        $isAdmin = Auth::user()->user_is_admin;
        $check_email = $this->checkUniqueEmail($request->user_email);
        if($check_email !== true) return $check_email;

        $user = new Cores_user();
        $user->user_name = $request->user_name??'';
        $user->user_login_name = $request->user_email??'';
        $user->user_email = $request->user_email??'';
        $user->user_phone = $request->user_phone??'';
        $user->password = bcrypt($request->password);
        $user->user_avatar = $request->user_avatar??'';
        $user->user_role = $request->user_role??'';
        $user->type_id = $request->type_id;
        $user->spec_id = $request->spec_id;
        $user->province_id = $request->province_id;
        $user->district_id = $request->district_id;
        $user->village_id = $request->village_id;
        $user->user_status = $request->user_status??0;
        $user->user_order = $request->user_order??0;

        if($isAdmin){
            $user->user_is_admin = $request->user_is_admin??0;
            $user->verified = $request->verified??0;
        }

        $user->save();
        ReOrder::_reorder($user,'','','user_order');

        $data_user_meta = [
            'user_job_title' => $request->user_job_title,
            'user_address' => $request->user_address,
            'personal_name' => $request->personal_name,
            'enterprise_website' => $request->enterprise_website,
        ];

        $user_meta = new Cores_user_meta();
        $user_meta->updateByMetaKey($user->id,$request->listPermit,Cores_user_meta::_CONST_PERMIT);
        $user_meta->updateByMetaKey($user->id,$request->listGroup,Cores_user_meta::_CONST_GROUP_PARENT);
        $user_meta->updateUserInfo($user->id,$data_user_meta);
        return response()->json('inserted!');
    }

    public function updateUser(MCAUserRequest $request){
        $id = $request->id;
        $params = $request->all();
        $isAdmin = Auth::user()->user_is_admin;
        if(!$isAdmin && Auth::id() !== $id) return response()->json('Not Access!',422);
        if(!$isAdmin) {
            unset($params['verified']);
            unset($params['user_is_admin']);
        }

        $check_email = $this->checkUniqueEmail($request->user_email,Cores_user::find($id)->user_email);
        if($check_email !== true) return $check_email;

        if(isset($params['password'])) $params['password'] = bcrypt($params['password']);
        $params['user_login_name'] = $params['user_email'];
        $user = Cores_user::find($id);
        $user->update($params);
        ReOrder::_reorder($user,'','','user_order');

        $data_user_meta = [
            'user_job_title' => $request->user_job_title,
            'user_address' => $request->user_address,
            'personal_name' => $request->personal_name,
            'enterprise_website' => $request->enterprise_website,
        ];

        $user_meta = new Cores_user_meta();
        $user_meta->updateByMetaKey($user->id,$request->listPermit,Cores_user_meta::_CONST_PERMIT);
        $user_meta->updateByMetaKey($user->id,$request->listGroup,Cores_user_meta::_CONST_GROUP_PARENT);
        $user_meta->updateUserInfo($user->id,$data_user_meta);
        return response()->json('updated!');
    }

    public function deleteUser($id){
        $isAdmin = Auth::user()->user_is_admin;
        if(!$isAdmin && Auth::id() !== $id) return response()->json('Not Access!',422);
        $user = Cores_user::find($id);
        $user->delete();
        return response()->json('deleted!');
    }

    public function getUserByEmail(Request $request){
        $user = Cores_user::where('user_email',$request->user_email)
                ->where('user_status',Cores_user::STATUS_ACTIVE)
                ->where('verified',Cores_user::USER_VERIFIED)
                ->first();
        if(!$user) {
            return response()->json(['errors'=>['user_email'=>['Người nhận này không tồn tại!']]],422);
        }

        return response()->json($user);
    }

    public static function getUserById($id){
        $user = Cores_user::where('id',$id)
                ->where('user_status',Cores_user::STATUS_ACTIVE)
                ->where('verified',Cores_user::USER_VERIFIED)
                ->first();

        return response()->json($user);
    }

    protected function getUserRole($user_role){
        $list_role = array_filter($user_role??[],function($item){
            return $item ===true;
        });
        return array_keys($list_role);
    }

    protected function checkUniqueEmail($user_email,$ignore_email=null){
        $check_unique_email = Cores_user::where('user_email',$user_email)
            ->where('user_email','<>',$ignore_email)
            ->where('verified',Cores_user::USER_VERIFIED)->count();
        if($check_unique_email > 0){
            return response()->json(['errors'=>['user_email'=>['Email đã tồn tại!']]],422);
        }
        return true;
    }

}
