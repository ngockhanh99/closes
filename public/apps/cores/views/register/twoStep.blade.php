<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>Đặt lại mật khẩu</title>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shorcut icon" type="image/x-ico" href="<?php echo url('apps/cores/images') ?>/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
          type="text/css"/>
    <!-- Icons Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="<?php echo url('theme/skote') ?>/assets/css/app.min.css" id="app-style" rel="stylesheet"
          type="text/css"/>

</head>

<body>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5 text-muted">
                    <a href="index.html" class="d-block auth-logo">
                    </a>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">

                    <div class="card-body">

                        <div class="p-2">
                            <div class="text-center">
                                <div class="avatar-md mx-auto">
                                    <div class="avatar-title rounded-circle bg-light">
                                        <i class="bx bxs-envelope h1 mb-0 text-primary"></i>
                                    </div>
                                </div>
                                <div class="p-2 mt-4">
                                    <h4>Xác nhận email của bạn</h4>
                                    <p class="mb-5">Vui lòng nhập mã 6 chữ cái, số được gửi đến <span
                                                class="fw-semibold">{{request()->email}}</span></p>
                                    <form  class="form-horizontal" action="{{url('admin/auth/register')}}" method="POST">
                                        <input type="hidden" name="email" value="{{request()->email}}">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit1-input" class="visually-hidden">Dight 1</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 2)" maxLength="1"
                                                           id="digit1-input">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit2-input" class="visually-hidden">Dight 2</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 3)" maxLength="1"
                                                           id="digit2-input">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit3-input" class="visually-hidden">Dight 3</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 4)" maxLength="1"
                                                           id="digit3-input">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Dight 4</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 5)" maxLength="1"
                                                           id="digit4-input">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Dight 4</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 6)" maxLength="1"
                                                           id="digit5-input">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Dight 4</label>
                                                    <input type="text" name="code[]" required
                                                           class="form-control form-control-lg text-center"
                                                           onkeyup="moveToNext(this, 7)" maxLength="1"
                                                           id="digit6-input">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <span style="color:red" class="help-block">{{$errors->first('errorCode')}}</span>
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-success w-md">Xác nhận</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">
                    {{--                    <p>Không nhận được mã<a href="#" class="fw-medium text-primary"> Gửi lại </a> </p>--}}
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

<!-- two-step-verification js -->
<script src="<?php echo url('theme/skote') ?>/assets/js/pages/two-step-verification.init.js"></script>

<!-- App js -->
<script src="<?php echo url('theme/skote') ?>/assets/js/app.js"></script>
</body>
</html>
