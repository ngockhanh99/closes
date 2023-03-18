<?php
namespace App\Http\Controllers;

use App\Models\Cores\Cores_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Validator;

class MCAResetPasswordController extends Controller
{
    public function index(){
        return view('cores.quen-mat-khau');
    }

    public function resetPassword(Request $request){
        $email = $request->user_email;
        $vertification = new VerificationCode();
        if(empty($email)){
            return back()->withErrors(['user_email'=>['Bạn chưa nhập Email!']])->withInput();
        }

        $check = Cores_user::where('user_email',$email)
                ->where('user_status',Cores_user::STATUS_ACTIVE)
                ->where('verified',Cores_user::USER_VERIFIED)->count();
        if(!$check){
            return back()->withErrors(['user_email'=>['Email không tồn tại!']])->withInput();
        }
        $vertification->sendEmail($email);
        $user_name = Cores_user::where('user_email',$email)->first()->user_name??'';
        return back()->with(['email'=>$email,'user_name'=>$user_name]);
    }

    public function changePasswordAfterVerify(Request $request){
        $code = join('',$request->code);
        $email = $request->user_email;
        
        $vertification = new VerificationCode();
        $check = $vertification->verifyResetCode($code,$email);

        if($check!==true){
            return $check;
        };

        $user_name = Cores_user::where('user_email',$email)->first()->user_name??'';

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:5|max:255|alpha_dash',
            'password_confirmation' => 'required|same:password|alpha_dash',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->with(['email'=>$email,'user_name'=>$user_name])->withInput();
        }

        $user = Cores_user::where('user_email',$email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        VerificationCode::where('code',$code)
            ->where('user_email',$email)
            ->where('used',false)->first()->update(['used'=>true]);

        return back()->with('message','Password Changed!');
    }

}