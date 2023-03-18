<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterEnterpriseRequest;
use App\Jobs\SendRegisterEmail;
use App\Models\MCA\SpecModel;
use App\Models\Cores\Cores_district;
use App\Models\Cores\Cores_ou;
use App\Models\Cores\Cores_province;
use App\Models\Cores\Cores_register_enterprise;
use App\Models\Cores\Cores_village;
use App\Models\MCA\TypeModel;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\MessageBag;
use App\Models\Cores\Cores_user;
use Illuminate\Http\Request;
use App\Notifications\ResetPasswordRequest;

class RegisterController extends RestController
{

    public function index()
    {
        $data = [];
        $data['enterpriseTypes'] = TypeModel::makeinstance()->getAll(['status' => 1]);
        $data['carrers'] = SpecModel::makeinstance()->getAll(['status' => 1]);

        $data['provinces'] = Cores_province::makeinstance()->getAll(['status' => 1]);
        $data['district'] = Cores_district::makeinstance()->getAll(['status' => 1]);
        $data['villages'] = Cores_village::makeinstance()->getAll(['status' => 1]);
        $data['arr_status'] = Cores_ou::makeInstance()->get_ou_status();
        return view('cores.views.register.index', $data);
    }

    public function registerSendMail(Request $request)
    {
        $rule = [
            'ou_name' => 'required',
            'user_login_name' => 'required|unique:users',
            'enterprise_type_id' => 'required',
            'career_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'address' => 'required',
            'user_email' => 'required|email|unique:users',
            'user_password' => 'required|min:6|confirmed',
        ];
        $info = [
            'ou_name' => $request->ou_name,
            'user_login_name' => $request->user_login_name,
            'enterprise_type_id' => $request->enterprise_type_id,
            'career_id' => $request->career_id,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'village_id' => $request->village_id,
            'address' => $request->address,
            'user_email' => $request->user_email,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'user_password' => $request->user_password,
            'ou_status' => $request->ou_status,
        ];
        $validator = Validator::make($request->all(), $rule);
        $this->withValidator($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $registerInfo = Cores_register_enterprise::updateOrCreate([
            'email' => $request->user_email,
        ], [
            'user_login_name' => $request->user_login_name,
            'token' => rand(100000, 999999),
            'info' => json_encode($info),
        ]);
        if ($registerInfo) {
            $this->dispatch(new SendRegisterEmail($request->user_email, 'mails.registerEnterprises', 'Đăng ký tài khoản', $registerInfo));
        }
        return redirect('/admin/auth/register/twoStep?email=' . $request->user_email);
    }

    public function twoStep(Request $request)
    {
        if (!$request->email) {
            return redirect('/admin/register');
        }
        return view('cores.views.register.twoStep');
    }

    public function register(Request $request)
    {
        $token = implode("", $request->code);
        $registerInfo = Cores_register_enterprise::where([
            ['token', $token],
            ['email', $request->email],
        ])->first();
        if (is_null($registerInfo)) {
            $errors = new MessageBag(['errorCode' => 'Mã xác nhận không đúng']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $info = json_decode($registerInfo->info, true);
        //Kiểm tra mã số thuế
        $count = Cores_ou::where('tax_code', $registerInfo->user_login_name)->count();
        if ($count) {
            $errors = new MessageBag(['errorCode' => 'Mã số thuế đã tồn tại']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        //kiểm tra tên đăng nhập nsd có tồn tại chưa
        $count = Cores_user::where('user_login_name', $registerInfo->user_login_name)->count();
        if ($count) {
            $errors = new MessageBag(['errorCode' => 'Mã số thuế đã tồn tại']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        //kiểm tra email nsd có tồn tại chưa
        $count = Cores_user::where('user_email', $registerInfo->email)->count();
        if ($count) {
            $errors = new MessageBag(['errorCode' => 'Email đã tồn tại']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        DB::beginTransaction();
        try {
            $params = [
                "ou_name" => $info['ou_name'],
                "enterprise_type_id" => $info['enterprise_type_id'],
                "career_id" => $info['career_id'],
                "tax_code" => $info['user_login_name'],
                "province_id" => $info['province_id'],
                "district_id" => $info['district_id'],
                "village_id" => $info['village_id'],
                "address" => $info['address'],
                "phone" => $info['phone'],
                "fax" => $info['fax'],
                "email" => $info['user_email'],
                "ou_status" => (int)$info['ou_status'],
                "verify" => 0,
                "ou_level" => Cores_ou::_CONST_CAP_SO,
            ];
            $v_id = Cores_ou::makeInstance()->insertGetId($params);
            //Them moi nsd
            $user_password = $info['user_password'] ? $info['user_password'] : '123456';
            //Build userInfo
            $userInfo = [
                'user_login_name' => $info['user_login_name'],
                'user_name' => $info['ou_name'],
                'user_email' => $info['user_email'],
                'password' => $user_password,
                'ou_id' => $v_id,
                'root_ou_id' => $v_id,
                'user_order' => 1,
                'user_status' => 1,
                'user_is_admin' => false,
            ];
            $userOther = [
                'user_address' => '',
                'user_job_title' => '',
                'user_phone' => '',
            ];
            Cores_user::makeInstance()->insertUser($userInfo, $userOther, [], [], []);
            $registerInfo->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['data' => ['message' => $ex->getMessage()]], 500);
            $errors = new MessageBag(['errorCode' => $ex->getMessage()]);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        return redirect('/admin/auth/register/done');
    }
    public function district(Request $request)
    {
        $datadistrict = Cores_district::where('province_id',$request->province_id)->get();
        return response(['data'=>$datadistrict]);
    }
    public function villages(Request $request)
    {
        $datavillages = Cores_village::where('district_id',$request->district_id)->get();
        return response(['data'=>$datavillages]);
    }
    public function done()
    {
        return view('cores.views.register.done');
    }
}
