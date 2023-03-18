<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;

class LoginCtrl extends RestController
{

//    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';


    function __construct()
    {
        //set redirect to after login
//        $this->redirectTo = route('defaultPageAfterLogin');
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {

        return view('cores.login');
    }


    public function login(Request $request)
    {
        $user_login_name = $request->input('user_login_name');
        $password        = $request->input('password');
        if (!Auth::attempt(['user_login_name' => $user_login_name, 'password' => $password, 'user_status' => 1, 'verified' => 1], $request->has('remember'))
            && !Auth::attempt(['user_email' => $user_login_name, 'password' => $password, 'user_status' => 1, 'verified' => 1], $request->has('remember'))
            && !Auth::attempt(['user_phone' => $user_login_name, 'password' => $password, 'user_status' => 1, 'verified' => 1], $request->has('remember')))
        {
            $errors = new MessageBag(['errorlogin' => 'Tài khoản hoặc mật khẩu không đúng']);
            return redirect()->back()->withInput()->withErrors($errors);
        }
        return redirect('/admin/');
    }

    function logout()
    {
        Auth::logout();
        return redirect('/admin/');
    }
}
