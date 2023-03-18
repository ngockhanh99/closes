<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{asset('apps/cores/css/dang-ky.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="{{asset('icons-1.8.1/font/bootstrap-icons.css')}}">
    <title><?php echo config("app.UNIT_NAME"); ?></title>
    <!-- App favicon -->
    <link rel="icon" href="<?php echo asset('apps/cores/images') ?>/hnd_logo.png" type="image/x-icon"/>
</head>

<body>
    <div class="register-cover">
        <div class="login-section">
            <div class="header-register">
                <label class="title">Đăng Nhập</label>
            </div>
            <div class="main-register" id="main_register">
                <form method="POST" action="{{url('admin/auth/login')}}" novalidate="novalidate">
                    {!! csrf_field() !!}
                    <div class="logo-section">
                        <img src="{{asset('apps/cores/images/mca-logo.png')}}" width="70%;">
                    </div>

                    <div id="step_1">
                        <span style="color:red" class="help-block">{{$errors->first('errorlogin')}}</span>
                        <div class="row mb-3">
                            <div class="input-group" style="width:85%; margin:auto">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                                <input type="text" class="form-control" placeholder="Nhập số điện thoại hoặc email doanh nghiệp" aria-describedby="basic-addon1" name="user_login_name" value="{{old('user_login_name')}}">
                                <span style="color:red" class="help-block">{{$errors->first('user_login_name')}}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="input-group" style="width:85%; margin:auto">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-phone"></i></span>
                                <input type="password" class="form-control" placeholder="Nhập mật khẩu" aria-describedby="basic-addon1" name="password" value="{{old('user_phone')}}">
                                <span style="color:red" class="help-block">{{$errors->first('password')}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center button-section">
                        <button type="submit" id="register_button" class="register-button">Đăng nhập</button>
                    </div>
                    <div class="row text-center" style="margin-top: 10px;">
                    <div style="margin-bottom: 15px;">
                        <a href="{{route('register.index')}}" style="color: black;">Đăng ký?</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{route('reset-password.index')}}" style="color: black;">Quên mật khẩu?</a>
                    </div>
                    <label class="font-normal" style="font-weight: bold;font-size: 14px;color: #000;; margin: 0">
                                        Hotline: <a href="tel:0886448119" style="color: #000">0246.6822.443</a>
                                    </label>
                    </div>
                    
                </form>
            </div>

        </div>
    </div>
</body>

</html>