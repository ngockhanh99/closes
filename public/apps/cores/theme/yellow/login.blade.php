
<html>
    <style>
        .wrapper {
            background: #d2d6de !important
        }

        .help-block {
            color: #f39c12
        }
    </style>
    <head>
        <title><?php echo config("app.UNIT_NAME");?></title>
        <meta name="csrf-token" content="<?php echo csrf_token() ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo url('theme') ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo url('theme') ?>/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->


        <link rel="stylesheet" href="<?php echo url('apps/cores/css') ?>/style.css">
        <link rel="stylesheet" href="<?php echo url('apps/cores/css') ?>/login.css">

        <link rel="shorcut icon" type="image/x-ico" href="<?php echo url('apps/cores/images') ?>/favicon.ico">

    </head>

    <body class="login-page">
        <div style="padding-top: 190px;padding-bottom: 100px;">
            <div class="login-box">
                <div class="login-logo">
                    <b><?php echo config("app.APP_FULL_NAME"); ?> <?php echo config("app.UNIT_NAME");?></b>
                </div>
                <!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">Đăng nhập</p>
                    <span style="color:red" class="help-block">{{$errors->first('errorlogin')}}</span>

                    <form action="{{url('admin/auth/login')}}" method="POST" role="form">
                        {!! csrf_field() !!}
                        <div class="form-group has-feedback">
                            <input type="text" name="user_login_name" class="form-control" placeholder="Nhập tên tài khoản ..."
                                   autofocus>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            <span style="color:red" class="help-block">{{$errors->first('user_login_name')}}</span>

                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu ..." name="password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <span style="color:red" class="help-block">{{$errors->first('password')}}</span>
                        </div>
                        <div class="row" style="text-align: center;">
                            <button type="submit" class="btn btn-primary btn-flat">Đăng nhập</button>
                        </div>
                        <br/>
                        <div class="row" style="text-align: center;">
                            <div class="login-or"><div class="or-left"></div>Hoặc<div class="or-right"></div></div>
                        </div>
                        <div class="social-auth-links text-center">
<!--                            <a href="{{ url('auth/facebook') }}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Đăng nhập bằng
                                Facebook</a>-->
                            <a href="{{ url('auth/google') }}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Đăng nhập bằng
                                Google+</a>
                        </div>

{{--                        <label class="font-normal">--}}
{{--                            <i class="fa fa-info-circle" style="color: #e88a05"></i>--}}
{{--                            Khi có sự cố đề nghị bật và sử dụng phần mềm Ultraviewer để được hỗ trợ <a target="_blank" href="https://ultraviewer.net/vi/download.html">(dowload tại đây)</a>.--}}
{{--                        </label>--}}
                        <label class="font-normal">
                            <i class="fa  fa-credit-card" style="color: #5299b7"></i>
                            Xây dựng bởi công ty Thiên An
                        </label>
                        <label class="font-normal">
                            <i class="fa  fa-credit-card" style="color: #5299b7"></i>
                            Hotline liên hệ: <a href="tel:0886448119" style="color: #fff">0886 448 119</a>
                        </label>

                    </form>

                </div>
                <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->
            <footer class="text-center hidden-xs hidden-sm" id="footerLogin">
                <h2 style="font-size:14px; margin:5px"> <b>Đơn vị quản lý:</b> <?php echo config("app.FOOTER_UNIT");?></h2>
                <h2 style="font-size:14px; margin:5px"> <b>Địa chỉ:</b> <?php echo config("app.FOOTER_ADDRESS");?></h2>
                <h2 style="font-size:14px; margin:5px"><b> ĐT</b>: <?php echo config("app.FOOTER_PHONE");?></h2>
                <h2 style="font-size:14px; margin:5px"> <b>E-mail</b>: <?php echo config("app.FOOTER_EMAIL");?></h2>
            </footer>
        </div>

    </body>
</html>
