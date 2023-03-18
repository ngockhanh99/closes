<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationEmail;
use App\Jobs\SendResetPasswordEmail;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use App\Models\Cores\Cores_user;
use Illuminate\Http\Request;
use App\Models\Cores\Cores_password_reset;
use App\Notifications\ResetPasswordRequest;

class ResetPasswordController extends Controller
{

    /**
     * Hiển thị giao diện nhập email quên mật khẩu
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPassword(Request $request)
    {
        return view('cores.views.changePassword.resetPassword');
    }

    /**
     * Hiển thị giao dienj nhập mã
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function authTwoStepVerification(Request $request)
    {
        if(!$request->email){
            return redirect('/admin/resetPassword');
        }
        return view('cores.views.changePassword.authTwoStepVerification');
    }
    /**
     * Gửi email mã mật khẩu
     * @param  ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function sendMail(Request $request)
    {
        $user = Cores_user::where('user_email', $request->email)
            ->orWhere('user_login_name', $request->email)
            ->first();
        if(is_null($user)){
            $errors = new MessageBag(['errorEamil' => 'Mã số thuế/email doanh nghiệp không đúng']);
            return redirect()->back()->withErrors($errors)->withInput();
        }
        if(!$user->user_email){
            $errors = new MessageBag(['errorEamil' => 'Doanh nghiệp chưa cập nhật email, vui lòng liên hệ bộ phận hỗ trợ để lấy lại mật khẩu']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $passwordReset = Cores_password_reset::updateOrCreate([
            'email' => $user->user_email,
        ], [
//            'token' => Str::random(6),
            'token' =>  rand(100000, 999999),
        ]);
        if ($passwordReset) {
            $this->dispatch(new SendResetPasswordEmail($user, 'mails.resetPassword', 'Lấy lại mật khẩu', $passwordReset));
        }
        return redirect('/admin/authTwoStepVerification?email=' . $user->user_email);
    }

    /**
     * Kiển tra mã
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function checkVerification(Request $request)
    {
        $token = implode("",$request->code);
        $passwordReset = Cores_password_reset::where([
            ['token', $token],
            ['email', $request->email],
        ])->first();
        if(is_null($passwordReset)){
            $errors = new MessageBag(['errorCode' => 'Mã xác nhận không đúng']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $user = Cores_user::where('user_email', $passwordReset->email)->first();
        if(is_null($user)){
            $errors = new MessageBag(['errorCode' => 'Email không tồn tại']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        return view('cores.views.changePassword.checkVerification',  ['user' => $user, 'passwordReset' => $passwordReset]);
    }

    public function changePassword(Request $request)
    {
        $passwordReset = Cores_password_reset::where('token', $request->code)->first();
        if(is_null($passwordReset)){
            $errors = new MessageBag(['errorCode' => 'Mã xác nhận không đúng']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $user = Cores_user::where('user_email', $passwordReset->email)->first();
        if(is_null($user)){
            $errors = new MessageBag(['errorCode' => 'Email không tồn tại']);
            return redirect()->back()->withInput()->withErrors($errors);
        }

        if(strlen($request->passwordNew) < 6){
            $errors = new MessageBag(['errorCode' => 'Mật khẩu phải lớn hơn 5 kí tự']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        $data = ['password' => bcrypt($request->passwordNew)];
        Cores_user::makeInstance()->changePassword($user->user_login_name, $data);
        $passwordReset->delete();
        return view('cores.views.changePassword.doneChangePassword',  ['user' => $user]);
    }
}