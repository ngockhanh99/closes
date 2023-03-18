<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Đổi mật khẩu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shorcut icon" type="image/x-ico" href="<?php echo url('apps/cores/images') ?>/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo url('theme/skote') ?>/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Đổi mật khẩu</h5>
                                    <p>Vui lòng nhập mật khẩu mới!</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo url('theme/skote') ?>/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div>
                            <a href="index.html">
                                <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="<?php echo url('theme/skote') ?>/assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form  action="{{url('changePassword')}}" method="POST">
                                <input type="hidden" name="code" value="{{$passwordReset->token}}">
                                <div class="user-thumb text-center mb-4">
                                    <img src="<?php echo url('apps/cores') ?>/images/avata-default.jpg" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                                    <h5 class="font-size-15 mt-3">{{$user->user_name}}</h5>
                                </div>

                                <div class="mb-3">
                                    <label for="userpassword">Mật khẩu mới</label>
                                    <input type="password" class="form-control" id="userpassword" name="passwordNew" placeholder="nhập mật khẩu mới">
                                </div>
                                <div>
                                    <span style="color:red" class="help-block">{{$errors->first('errorCode')}}</span>
                                </div>

                                <div class="text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Cập nhật</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Không phải bạn ? trở lại <a href="{{url('/')}}" class="fw-medium text-primary"> Đăng nhập </a> </p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="<?php echo url('theme/skote') ?>/assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/node-waves/waves.min.js"></script>

<!-- App js -->
<script src="<?php echo url('theme/skote') ?>/assets/js/app.js"></script>

</body>
</html>
