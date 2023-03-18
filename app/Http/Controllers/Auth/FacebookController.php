<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Socialite;
use Exception;
use Auth;
use App\Models\Cores\Cores_user;
use Illuminate\Support\MessageBag;

class FacebookController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try
        {
            $user     = Socialite::driver('facebook')->user();
            $userInfo = Cores_user::where([
                        ['user_email', $user->getEmail()],
                        ['user_status', 1],
                    ])->first();
            if (is_null($userInfo))
            {
                $errors = new MessageBag(['errorlogin' => 'Tài khoản Facebook của bạn chưa được cấp quyền trong phần mềm']);
                return redirect('login')->withInput()->withErrors($errors);
            }
            if (!$userInfo->user_avatar)
            {
                $userInfo->user_avatar = $user->getAvatar();
            }

            $userInfo->save();
            Auth::loginUsingId($userInfo->id);

            return redirect('/');
        }
        catch (Exception $e)
        {
            return redirect('login');
        }
    }

}
