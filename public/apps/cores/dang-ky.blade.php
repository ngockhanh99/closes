<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="{{asset('apps/cores/css/dang-ky.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Đăng ký</title>
</head>

<body>
<div class="register-cover">
    <div class="register-section">
        <div class="header-register">
            <label class="title">Đăng ký tài khoản</label>
            <div style="color: #ffffff;">Đăng ký để nhận tài khoản của bạn ngay bây giờ.</div>
        </div>
        <div class="main-register" id="main_register">
            <form method="POST" action="{{route('register.insert')}}">
                @csrf
                <div class="logo-section">
                    <img src="{{asset('apps/cores/images/mca-logo.png')}}" width="70%;">
                </div>

                {{-- Bước 1--}}
                <div id="step_1">
                    <div class="row mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-phone"></i></span>
                            <input type="text" class="form-control" placeholder="Nhập số điện thoại ..."
                                   aria-describedby="basic-addon1" name="user_phone" value="{{old('user_phone')}}">
                        </div>
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('user_phone')}}</span>
                    </div>
                    <div class="row mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                            <input type="text" class="form-control"
                                   placeholder="Nhập địa chỉ Email ... (Không bắt buộc)" aria-describedby="basic-addon1"
                                   name="user_email" value="{{old('user_email')}}">
                        </div>
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('user_email')}}</span>
                    </div>

                    <div class="row mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
                            <input type="text" style="position: absolute;right: 50px;top: 0px;" name="user_name_fk">
                            <input type="text" class="form-control" placeholder="Tên doanh nghiệp, tổ chức ..."
                                   aria-describedby="basic-addon1" name="user_name" value="{{old('user_name')}}">
                        </div>
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('user_name')}}</span>
                    </div>

                    <div class="row">
                        <label class="fw-bold">Loại hình doanh nghiệp:</label>
                        @foreach($types as $type)
                            <div class="col-md-6">
                                <div class="form-check mt-2 mx-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               {{$type->id == old('type_id')?'checked':''}} name="type_id"
                                               value="{{$type->id}}" type="radio">
                                        {{$type->name}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('type_id')}}</span>
                    </div>
                </div>

                {{-- Bước 2--}}
                <div id="step_2">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="form-control" name="province_id">
                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                @foreach($provinces as $province )
                                    <option
                                        value="{{$province->id}}" {{old('province_id') == $province->id?'selected':''}}>
                                        {{$province->name}}
                                    </option>
                                @endforeach
                            </select>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('province_id')}}</span>
                        </div>

                        <div class="col-md-4 g-0">
                            <select class="form-control" name="district_id">
                                <option value="">-- Chọn Quận/Huyện --</option>
                            </select>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('district_id')}}</span>
                        </div>

                        <div class="col-md-4">
                            <select class="form-control" name="village_id">
                                <option value="">-- Chọn Xã/Phường --</option>
                            </select>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('village_id')}}</span>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-house-door"></i></span>
                            <input type="text" class="form-control" placeholder="Địa chỉ cụ thể ..." name="address"
                                   aria-describedby="basic-addon1" value="{{old('address')}}">
                        </div>
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('address')}}</span>
                    </div>

                    <div class="row">
                        <label class="fw-bold">Vai trò:</label>
                        @foreach($list_role as $key=>$role)
                            <div class="col-md-6">
                                <div class="form-check mt-2 mx-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               {{old('user_role') == $key?'checked':''}} name="user_role" type="radio"
                                               value="{{$key}}">
                                        {{$role}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('user_role')}}</span>
                    </div>

                </div>

                {{-- Bước 3--}}
                <div id="step_3">
                    <div class="row mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password_fk" style="position: absolute;top:0px;right:50px;">
                            <input type="password" class="form-control" placeholder="Nhập mật khẩu ..."
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
                        <span
                            style="color:#dc3545;font-style:italic;">{{$errors->first('password_confirmation')}}</span>
                    </div>

                    <div class="row">
                        <label class="fw-bold">Lĩnh vực tham gia:</label>
                        @foreach($specs as $spec)
                            <div class="col-md-6">
                                <div class="form-check mt-2 mx-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input"
                                               {{$spec->id == old('spec_id')?'checked':''}} name="spec_id"
                                               value="{{$spec->id}}" type="radio">
                                        {{$spec->name}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                        <span style="color:#dc3545;font-style:italic;">{{$errors->first('spec_id')}}</span>
                    </div>

                </div>

                <div class="mt-4 text-center button-section">
                    <button id="continue_button" type="button" class="register-button">Tiếp tục</button>
                    <button type="submit" id="register_button" class="register-button">Đăng ký</button>
                    <button type="button" id="back_button" class="button-back"><i class="bi bi-arrow-return-left"></i>
                        Quay lại
                    </button>
                    <div class="mt-3">Bạn có sẵn tài khoản?
                        <a href="{{route('login')}}">Đăng nhập</a>
                    </div>
                </div>

            </form>
        </div>

        <div class="reset-section" id="enter_code" style="display: none">
            <div class="header-reset">
                <label class="title">Nhập mã xác thực</label>
            </div>
            <div class="main-reset">
                <form method="POST" action="{{route('register.verifyEmail')}}">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-9">
                            <label style="text-align: center;font-size:16px;display: block;margin-bottom:15px;color:#019341;">Vui lòng liên hệ quản trị hoặc kiểm tra Email đã đăng ký để lấy mã xác thực.</label>
                            <label style="text-decoration: underline;">Xin hãy nhập mã xác thực mà bạn nhận được:</label>
                            <div style="font-size: 14px;font-style:italic;margin-bottom:10px;">
                                (Mã xác thực bao gồm 6 ký tự.)
                            </div>
                            <input hidden name="user_email" value="{{session('email')}}">
                            <input hidden name="user_id" value="{{session('user_id')}}">
                            <div class="row justify-content-around mt-4">
                                <input maxlength="1" required value="{{old('code.0')}}" name="code[]"
                                       class="form-control bg-light input-code" autocomplete="off"/>
                                <input maxlength="1" required value="{{old('code.1')}}" name="code[]"
                                       class="form-control bg-light input-code" autocomplete="off"/>
                                <input maxlength="1" required value="{{old('code.2')}}" name="code[]"
                                       class="form-control bg-light input-code" autocomplete="off"/>
                                <input maxlength="1" required value="{{old('code.3')}}" name="code[]"
                                       class="form-control bg-light input-code" autocomplete="off"/>
                                <input maxlength="1" required value="{{old('code.4')}}" name="code[]"
                                       class="form-control bg-light input-code" autocomplete="off"/>
                                <input maxlength="1" readonly onfocus="this.removeAttribute('readonly');" required
                                       value="{{old('code.5')}}" name="code[]" class="form-control bg-light input-code"
                                       autocomplete="off"/>
                            </div>
                            <span style="color:#dc3545;font-style:italic;">{{$errors->first('code')}}</span>
                        </div>
                    </div>

                    <div class="button-section text-center mt-5 mb-5">
                        <button type="submit" class="register-button">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Modal thông báo--}}
<div class="modal fade" id="message_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle text-info" style="font-size: 60px;"></i>
                </div>
                <div class="text-info text-center" style="font-size:18px;">Đăng ký tài khoản thành công!</div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="window.location.href = '<?php echo asset('/') ?>admin/login'"
                        class="btn btn-secondary" data-bs-dismiss="modal">Xác nhận
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal thông báo lỗi đăng ký tài khoản --}}
<div class="modal fade" id="error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle text-danger" style="font-size: 60px;"></i>
                </div>
                <div class="text-danger text-center" style="font-size:16px;">Có lỗi vui lòng kiểm tra lại thông tin đã nhập!</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<script>
    const second_step = document.getElementById('second_step')
    const list_enterprise = document.querySelectorAll('.enterprise')
    const role = document.querySelector('select[name=user_role]')
    const province = document.querySelector('select[name=province_id]')
    const district = document.querySelector('select[name=district_id]')
    const village = document.querySelector('select[name=village_id]')
    const register = document.getElementById('main_register')
    const enter_code = document.getElementById('enter_code')
    const stepView = {
        step_1: document.getElementById('step_1'),
        step_2: document.getElementById('step_2'),
        step_3: document.getElementById('step_3'),
    }
    const button = {
        continue: document.getElementById('continue_button'),
        register: document.getElementById('register_button'),
        back: document.getElementById('back_button'),
    }

    const SITE_ROOT = '{{asset('/')}}'
    let status = '{{session('success')}}'
    let message = '{{session('message')}}'
    let error_code = '{{$errors->first('code')}}'
    let isError = '{{$errors}}'

    let STEP = 1

    if (message == 'Verified Email!') {
        let myModal = new bootstrap.Modal(document.getElementById('message_modal'), {
            keyboard: false,
            backdrop: 'static'
        })
        myModal.show()
    }

    if (status || error_code) {
        enter_code.style.display = 'block'
        register.style.display = 'none'
    } else if (isError.length > 2) {
        let myModal = new bootstrap.Modal(document.getElementById('error_modal'), {
            keyboard: false,
            backdrop: 'static'
        })
        myModal.show()
    }

    initialProvince()

    province.onchange = changeDistrict
    district.onchange = changeVillage

    const handleView = {
        start() {
            handleView.continueHandle()
            handleView.showOrHideView()
        },
        continueHandle() {
            button.continue.onclick = function () {
                STEP += 1
                handleView.showOrHideView()
            }

            button.back.onclick = function () {
                STEP -= 1
                handleView.showOrHideView()
            }
        },
        showOrHideView() {
            if (STEP == 1) button.back.style.display = 'none'
            else button.back.style.display = 'block'

            if (STEP >= 3) {
                button.continue.style.display = 'none'
                button.register.style.display = 'block'
            } else {
                button.continue.style.display = 'block'
                button.register.style.display = 'none'
            }

            for (let key in stepView) {
                if (STEP == key.charAt(key.length - 1)) stepView[key].style.display = 'block'
                else stepView[key].style.display = 'none'
            }
        }
    }

    handleView.start()

    function initialProvince() {
        province.value = 15
        changeDistrict()
    }

    function changeDistrict() {
        resetDistrictVillage()
        fetch(SITE_ROOT + 'rest/district/get-by-province?province_id=' + province.value)
            .then(response => response.json())
            .then(data => {
                html = '<option value="">-- Chọn Quận/Huyện --</option>'
                html += data.map(item => {
                    return `<option value='${item.id}'>${item.name}</option>`
                }).join('')
                district.innerHTML = html
            })
    }

    function changeVillage() {
        fetch(SITE_ROOT + 'rest/village/get-by-district?district_id=' + district.value)
            .then(response => response.json())
            .then(data => {
                html = '<option value="">-- Chọn Xã/Phường --</option>'
                html += data.map(item => {
                    return `<option value='${item.id}'>${item.name}</option>`
                }).join('')
                village.innerHTML = html
            })
    }

    function resetDistrictVillage() {
        district.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>'
        village.innerHTML = '<option value="">-- Chọn Xã/Phường --</option>'
    }
</script>
</body>

</html>
