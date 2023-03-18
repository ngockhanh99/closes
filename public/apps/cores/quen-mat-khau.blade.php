<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('apps/cores/css/quen-mat-khau.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Document</title>
</head>
<body>
<div class="reset-section" id="enter_email">
    <div class="header-reset">
        <label class="title">Đặt lại mật khẩu</label>
    </div>
    <div class="main-reset">
        <div class="logo-section">
            <img src="{{asset('apps/cores/images/mca-logo.png')}}" width="60%;">
        </div>
        <form method="POST" action="{{route('reset-password.resetPassword')}}">
            <div class="mt-3 row justify-content-center">
                <div class="col-md-8">
                    <label class="title-email">Nhập Email đăng ký của bạn<span style="color:#dc3545;">*</span></label>
                    <div style="font-size: 14px;font-style:italic;margin-bottom:10px;">
                        (Chúng tôi sẽ gửi thông tin xác thực đến email của bạn.<br>Vui lòng nhập chính xác Email!)
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" required placeholder="Nhập địa chỉ Email ..."
                               aria-describedby="basic-addon1" name="user_email" value="{{old('user_email')}}">
                    </div>
                    <span style="color:#dc3545;font-style:italic;">{{$errors->first('user_email')}}</span>
                </div>
            </div>

            <div class="button-section text-center mt-4">
                <button type="submit" class="button-submit">Xác nhận</button>
                <div class="mt-3">Hoặc
                    <a href="{{route('login')}}">Đăng nhập</a> nếu bạn nhớ mật khẩu.</div>
            </div>
        </form>
    </div>
</div>

{{--Enter code --}}
<div class="reset-section" id="enter_code" style="display: none">
    <div class="header-reset">
        <label class="title">Nhập mã xác thực</label>
    </div>
    <div class="main-reset">
        <form method="POST" action="{{route('reset-password.verifyResetCode')}}">
            <div class="mt-3 row justify-content-center">
                <div class="col-md-9">
                    <label style="text-align: center;font-size:18px;display: block;color: grey;font-weight: bold;">
                        Chào mừng <b>{{session('user_name')}}</b> quay trở lại!</label>
                    <label class="title-email">Xin hãy nhập mã xác thực mà bạn nhận được:</label>
                    <div style="font-size: 14px;font-style:italic;margin-bottom:10px;">
                        (Mã xác thực bao gồm 6 ký tự.<br>Vui lòng kiểm tra Email để nhận mã.)</div>
                    <input hidden name="user_email" value="{{session('email')}}" >
                    <div class="row justify-content-around">
                        <input maxlength="1" required value="{{old('code.0')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off"/>
                        <input maxlength="1" required value="{{old('code.1')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off"/>
                        <input maxlength="1" required value="{{old('code.2')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off" />
                        <input maxlength="1" required value="{{old('code.3')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off" />
                        <input maxlength="1" required value="{{old('code.4')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off" />
                        <input maxlength="1" readonly onfocus="this.removeAttribute('readonly');" required value="{{old('code.5')}}" name="code[]" class="form-control bg-light input-code" autocomplete="off" />
                    </div>
                    <span style="color:#dc3545;font-style:italic;">{{$errors->first('code')}}</span>

                    <div class="input-password mt-4">
                        <div class="row mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" placeholder="Nhập mật khẩu mới ..."
                                       aria-describedby="basic-addon1" name="password">
                            </div>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('password')}}</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" placeholder="Xác nhận mật khẩu ..."
                                       aria-describedby="basic-addon1" name="password_confirmation">
                            </div>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('password_confirmation')}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-section text-center mt-4">
                <button type="submit" class="button-submit">Xác nhận</button>
                <div class="mt-3">Hoặc
                    <a href="{{route('login')}}">Đăng nhập</a> nếu bạn nhớ mật khẩu.</div>
            </div>
        </form>
    </div>
</div>

{{--    Modal thông báo--}}
<div class="modal fade" id="message_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle text-info" style="font-size: 60px;"></i>
                </div>
                <div class="text-info text-center" style="font-size:18px;">Chúc mừng bạn đã đặt lại mật khẩu thành công!</div><br>
                <div class="text-center">Bạn đã có thể <a href="{{route('login')}}">Đăng nhập</a> vào hệ thống với mật khẩu vừa tạo!</div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="window.location.href = '<?php echo asset('/') ?>admin/login'" class="btn btn-success" data-bs-dismiss="modal">Đăng nhập</button>
            </div>
        </div>
    </div>
</div>

<script>
const email = "{{session('email')}}";
const message = "{{session('message')}}";
const enter_code = document.getElementById('enter_code')
const enter_email = document.getElementById('enter_email')
const user_email = document.querySelector('input[name=user_email]')
if(email){
    enter_code.style.display = 'block'
    enter_email.style.display = 'none'
}
if(message == 'Password Changed!'){
    let myModal = new bootstrap.Modal(document.getElementById('message_modal'), {keyboard:false,backdrop:'static'})
    myModal.show()
}
</script>
</body>
</html>