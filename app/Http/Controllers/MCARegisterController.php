<?php
namespace App\Http\Controllers;

use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\MCA\SpecModel;
use App\Models\MCA\TypeModel;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\VerificationCode;

class MCARegisterController extends Controller
{
    public function index(){
        $specs = SpecModel::where('status',SpecModel::STATUS_ACTIVE)->get();
        $types = TypeModel::where('status',TypeModel::STATUS_ACTIVE)->get();
        $provinces = Cores_province::where('status',Cores_province::STATUS_ACTIVE)->get();
        $list_role = Cores_user::LIST_ROLE;
        return view('cores.dang-ky',compact('list_role','specs','types','provinces'));
    }

    public function insert(Request $request)
    {
        $rule = [
            'user_name' => 'required|min:3|max:255',
            'user_email' => ['nullable','email','max:255', function($attribute, $value, $fail){
                $check_unique_email = Cores_user::where('user_email', $value)
                            ->where('verified', Cores_user::USER_VERIFIED)->count();
                if($check_unique_email > 0){
                    $fail('Email này đã được sử dụng!');
                }
            }],
            'user_phone' => ['required', 'min:5', 'max:20', function($attribute, $value, $fail){
                $check_unique_phone = Cores_user::where('user_phone', $value)
                                ->where('verified', Cores_user::USER_VERIFIED)->count();
                if($check_unique_phone > 0){
                    $fail('Số điện thoại này đã được sử dụng!');
                }
            }],
            'password' => 'required|min:5|max:255|alpha_dash',
            'password_confirmation' => 'required|same:password|alpha_dash',
            'user_role' => 'required',
            'job' => 'nullable|max:255',
            'personal_name' => 'nullable|min:3|max:255',
            'user_avatar' => 'nullable',
            'address' => 'required|min:3',
            'province_id' => 'required|exists:cores_province,id',
            'district_id' => 'required|exists:cores_district,id',
            'village_id' => 'required|exists:cores_village,id',
            'type_id' => 'required',
            'spec_id' => 'required',
            'enterprise_website' => 'nullable|max:255|url',
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if($request->hasFile('user_avatar')){
            $file = $request->file('user_avatar');
            $extension = $file->getClientOriginalExtension();
            $path = $file->storeAs('public/user_avatar',Str::random(40).'.'.$extension);
            $path = str_replace('public','storage',$path);
        }

//        Lưu vào bảng user
        $user = new Cores_user();
        $user->user_name = $request->user_name??'';
        $user->user_login_name = $request->user_email??'';
        $user->user_email = $request->user_email??'';
        $user->user_phone = $request->user_phone??'';
        $user->password = bcrypt($request->password);
        $user->user_avatar = $path??'';
        $user->user_role = $request->user_role??'';
        $user->type_id = $request->type_id;
        $user->spec_id = $request->spec_id;
        $user->province_id = $request->province_id;
        $user->district_id = $request->district_id;
        $user->village_id = $request->village_id;
        $user->user_status = Cores_user::STATUS_ACTIVE;
        $user->save();

        $list_group_id = Cores_group::where('group_code',$request->user_role)->get()->map(function($item){
            return $item->group_id;
        })->toArray();

        $data_user_meta = [
            'user_job_title' => $request->job,
            'user_address' => $request->address,
            'personal_name' => $request->personal_name,
            'enterprise_website' => $request->enterprise_website,
        ];

        $user_meta = new Cores_user_meta();
        $user_meta->updateByMetaKey($user->id,$list_group_id,Cores_user_meta::_CONST_GROUP_PARENT);
        $user_meta->updateUserInfo($user->id,$data_user_meta);
        $vertification = new VerificationCode();
        $vertification->sendEmail($request->user_email,$user->id);

        return back()->with(['success' => 'Registed!','email'=>$request->user_email,'user_id'=>$user->id]);
    }

    public function verifyEmail(Request $request){
        $code = join('',$request->code);
        $email = $request->user_email;
        $id = $request->user_id;

        $vertification = new VerificationCode();
        $check = $vertification->verifyResetCode($code, $email, $id);

        if($check!==true) return $check;

        Cores_user::where('user_email',$email)->where('id','<>',$id)->delete();
        Cores_user::find($id)->update(['verified'=>true]);

        return back()->with('message','Verified Email!');
    }
}
