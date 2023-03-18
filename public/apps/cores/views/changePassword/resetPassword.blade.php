

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Đặt lại mật khẩu</title>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
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
                                    <h5 class="text-primary">Đặt lại mật khẩu</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo url('theme/skote') ?>/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div>
                            <a>
                                <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="<?php echo url('theme/skote') ?>/assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                            </span>
                                </div>
                            </a>
                        </div>

                        <div class="p-2">
                            <div class="alert alert-success text-center mb-4" role="alert">
                                Nhập mã số thuế của doanh nghiệp và hướng dẫn sẽ được gửi cho email của doanh nghiệp!
                            </div>
                            <form class="form-horizontal" action="{{url('resetPassword')}}" method="POST">
                                {!! csrf_field() !!}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Mã số thuế/email doanh nghiệp</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="nhập mã số thuế/email doanh nghiệp" required
                                    value="{!! old('email') !!}">
                                    <span style="color:red" class="help-block">{{$errors->first('errorEamil')}}</span>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Xác nhận</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Nhớ mật khẩu? <a href="{{url('/')}}" class="fw-medium text-primary"> Đăng nhập tại đây</a> </p>
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
