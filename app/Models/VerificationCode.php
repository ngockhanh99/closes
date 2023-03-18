<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\Cores\Cores_user;
use Illuminate\Support\Str;

class VerificationCode extends Model
{
    const TIME_LIFE = 10;
    protected $table = 'verification_code';
    protected $fillable = [
        'user_id',
        'code',
        'user_email',
        'used',
    ];

    public function verifyResetCode($code,$email,$id=null){
        $user_name = Cores_user::where('user_email',$email)->first()->user_name??'';

        $verification = self::where('code',$code)
            ->where('user_email',$email??'')
            ->where('used',false)
            ->where('user_id',$id)->first();

        if(!$verification){
            return back()->withErrors(['code'=>['Mã xác thực không chính xác hoặc đã được sử dụng.']])
                ->with(['email'=>$email,'user_name'=>$user_name,'user_id'=>$id])->withInput();
        }

        $time_life = strtotime('+'.self::TIME_LIFE.' minute',strtotime($verification->created_at));
        if($time_life <= time()){
            $verification->update(['used'=>true]);
            return back()->withErrors(['code'=>['Mã xác thực này đã hết hạn (Mỗi mã xác thực chỉ tồn tại '.self::TIME_LIFE.' phút)!']])
                ->with(['email'=>$email,'user_name'=>$user_name,'user_id'=>$id])->withInput();
        }

        return true;
    }

    public function sendEmail($email, $id = null){
        $code = Str::random(6);
        $code = Str::upper($code);
        Mail::to($email)->send(new ResetPasswordMail($code));
        self::create([
            'user_id'=>$id,
            'code'=>$code,
            'user_email'=>$email??'',
        ]);
    }
}
