<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{asset('apps/frontend/css/login.css')}}">
</head>

<body>
    <div class="container">

        <div class="form login" id="form">
            <div class="content">
                <h1>Đăng nhập</h1>
                <form action="{{url('admin/auth/login')}}" novalidate="novalidate" method="post">
                        {!! csrf_field() !!}
                        <span style="color:red" class="help-block">{{$errors->first('errorlogin')}}</span>
                    <div class="group">
                        <input type="text" id="email-login" name='user_login_name' autocomplete="off" class="inputText"
                            placeholder="&nbsp;" required>
                        <label for="email-login">Tên đăng nhập</label>
                    </div>
                    <i class="text-danger" style="display: block;" id="error-email-login"></i>
                    <div class="group">
                        <input type="password" id="password-login " name="password" autocomplete="off" class="inputText"
                            placeholder="&nbsp;" required>
                        <label for="password-login">Mật khẩu</label>
                    </div>
                    <i class="text-danger" style="display: block;" id="error-password-login"></i>
                    <button type="submit">Đăng nhập</button> 
                </form>
            </div>

            <div class="content">
                <h1>Đăng ký</h1>
                <form action="{{asset('auth/register')}}" novalidate="novalidate" method="post"
                    onsubmit="return validateForm();">
                    {!! csrf_field() !!}
                    <div class="group">
                        <input type="email" id="email-reg" min="11" name='email' class="inputText" placeholder="&nbsp;"
                            required>
                        <label for="email-reg">Email</label>
                    </div>
                    <i class="text-danger" style="display: block;" id="error-email"></i>
                    <i style="color:red;">{{$errors->first('errorlogin')}}</i>
                    <div class=" group">
                        <input type="password" min="5" id="pass-reg" name="password" class="inputText"
                            placeholder="&nbsp;" required>
                        <label for="pass-reg">Mật khẩu</label>
                    </div>
                    <i class="text-danger" style="display: block;" id="error-password"></i>
                    <button type="submit">Đăng ký</button>
                </form>

            </div>
            <div class="form-rotate">
                <div id="rotate"></div>
            </div>
        </div>
        <div class="option">
            <div class="bg-active" id="bg-active"></div>
            <div class="changeType active" id="login">Đăng nhập</div>
            <div class="changeType" id="register">Đăng ký</div>
        </div>
    </div>
    <script src="{{asset('apps/frontend/js/login.js')}}"></script>
</body>

</html>