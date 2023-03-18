<?php

namespace App\Http\Controllers;

use App\Models\Cores\Cores_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\Cores\Cores_user_client;

class LoginController extends RestController
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
    public function register(Request $request)
    {
        $mail=$request->email??'';
        $check = Cores_user::where('user_login_name','like',$mail)->count();
        if($check>0){
            return redirect()->back()->withInput()->withErrors(new MessageBag(['errorlogin' => 'Email đã tồn tại!!!']));
        }
        $user = Cores_user::create([
            'admin'=>$request->email,
            'user_name'=>$request->email,
            'user_login_name'=>$request->email,
            'root_ou_id' =>0,
            'ou_id' =>0, 
            'user_phone' =>0,
            'user_order' =>1,
            'verified'=>1,
            'password'=>bcrypt($request->password)
        ]);
        Auth::loginUsingId($user->id);
        return redirect("/");
    }

    public function index()
    {

        return view('frontend.login');
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