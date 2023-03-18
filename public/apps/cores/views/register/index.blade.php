<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <title>Đăng ký</title>
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
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-9 col-xl-9">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-primary">Đăng ký</h5>
                                    <p>Đăng ký để nhận tài khoản của bạn ngay bây giờ.</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="<?php echo url('theme/skote') ?>/assets/images/profile-img.png" alt=""
                                     class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div>
                            <a>
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="<?php echo url('theme/skote') ?>/assets/images/logo.svg"
                                             alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <form class="needs-validation" class="form-horizontal" action="{{url('admin/auth/registerSendMail')}}"
                                  method="POST">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Tên doanh nghiệp<span style="color: #d81b1b">*</span></label>
                                        <input type="text" class="form-control" name="ou_name"
                                               value="{{old('ou_name')}}" required
                                               placeholder="nhập tên doanh nghiệp" >
                                        <span style="color:red" class="help-block">{{$errors->first('ou_name')}}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mã số thuế<span
                                                    style="color: #d81b1b">*</span></label>
                                        <input type="text" class="form-control" name="user_login_name"
                                               value="{{old('user_login_name')}}"
                                               placeholder="nhập mã số thuế" required >
                                        <span style="color:red" class="help-block">{{$errors->first('user_login_name')}}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Loại hình doanh nghiệp<span
                                                    style="color: #d81b1b">*</span></label>
                                        <select class="form-control" name="enterprise_type_id" required>
                                            <option value="">-- Chọn loại hình doanh nghiệp --</option>
                                            @foreach($enterpriseTypes as $val)
                                                <option value="{{$val->id}}" {{old('enterprise_type_id') == $val->id ? 'selected' : ''}}>
                                                    {{$val->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('enterprise_type_id')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Ngành nghề sản xuất, kinh doanh<span
                                                    style="color: #d81b1b">*</span></label>
                                        <select class="form-control" name="career_id"  value="{{old('career_id')}}" required>
                                            <option value="">-- Chọn ngành nghề sản xuất, kinh doanh --</option>
                                            @foreach($carrers as $val)
                                                <option value="{{$val->id}}" {{old('career_id') == $val->id ? 'selected' : ''}}>
                                                    {{$val->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('career_id')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Tỉnh/Thành<span
                                                    style="color: #d81b1b">*</span></label>
                                        <select class="form-control province" name="province_id" data-type="province"  value="{{old('province_id')}}" required>
                                            <option value="">-- Chọn tỉnh/Thành --</option>
                                            @foreach($provinces as $val)
                                                <option value="{{$val->id}}" {{old('province_id') == $val->id ? 'selected' : ''}}>
                                                    {{$val->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('province_id')}}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Quận/Huyện<span
                                                    style="color: #d81b1b">*</span></label>
                                        <select class="form-control district" name="district_id"  data-type="district" value="{{old('district_id')}}" required>
                                            <option value="">-- Chọn quận/huyện --</option>
<!--                                            @foreach($district as $val)
                                                <option value="{{$val->id}}" {{old('district_id') == $val->id ? 'selected' : ''}}>
                                                    {{$val->name}}
                                                </option>
                                            @endforeach-->
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('district_id')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Xã/phường<span style="color: #d81b1b">*</span></label>
                                        <select class="form-control village" data-type="village" name="village_id"  value="{{old('village_id')}}" required>
                                            <option value="">-- Chọn xã/phường --</option>
<!--                                            @foreach($villages as $val)
                                                <option value="{{$val->id}}" {{old('village_id') == $val->id ? 'selected' : ''}}>
                                                    {{$val->name}}
                                                </option>
                                            @endforeach-->
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('village_id')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Địa chỉ<span style="color: #d81b1b">*</span></label>
                                        <input type="text" class="form-control" name="address" value="{{old('address')}}"
                                               placeholder="Số 25, Thôn hạ"  required>
                                        <span style="color:red" class="help-block">{{$errors->first('address')}}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Số điện thoại doanh nghiệp</label>
                                        <input type="text" class="form-control" name="phone" value="{{old('phone')}}"
                                               placeholder="nhập số điện thoại doanh nghiệp" >
                                        <span style="color:red" class="help-block">{{$errors->first('phone')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Fax doanh nghiệp</label>
                                        <input type="text" class="form-control" name="fax" value="{{old('fax')}}"
                                               placeholder="nhập fax doanh nghiệp" >
                                        <span style="color:red" class="help-block">{{$errors->first('fax')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Email doanh nghiệp<span
                                                    style="color: #d81b1b">*</span></label>
                                        <input type="email" class="form-control" name="user_email" value="{{old('user_email')}}"
                                               placeholder="nhập email doanh nghiệp" required >
                                        <span style="color:red" class="help-block">{{$errors->first('user_email')}}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-control" name="ou_status" value="{{old('ou_status')}}">
                                            @foreach($arr_status as $key => $val)
                                                <option value="{{$key}}" {{old('ou_status') == $key? 'selected' : ''}}>
                                                    {{$val}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span style="color:red" class="help-block">{{$errors->first('ou_status')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Mật khẩu<span style="color: #d81b1b">*</span></label>
                                        <input type="password" class="form-control" name="user_password"
                                               placeholder="nhập mật khẩu" required >
                                        <span style="color:red" class="help-block">{{$errors->first('user_password')}}</span>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Nhập lại mật khẩu<span style="color: #d81b1b">*</span></label>
                                        <input type="password" class="form-control" name="user_password_confirmation"
                                               placeholder="Xác nhận mật khẩu" required >
                                        <span style="color:red" class="help-block">{{$errors->first('user_password_confirmation')}}</span>
                                    </div>
                                </div>
                                <div class="mt-4 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        Đăng ký
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <div>
                        <p>Bạn có sẵn tài khoản? <a href="{{url('/')}}" class="fw-medium text-primary"> Đăng nhập</a>
                        </p>
                    </div>
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

<!-- validation init -->
<script src="<?php echo url('theme/skote') ?>/assets/js/pages/validation.init.js"></script>

<!-- App js -->
<script src="<?php echo url('theme/skote') ?>/assets/js/app.js"></script>
<script>
    $(document).ready(function(){
        $('.province').change(function(){
            let provinceId = $(this).val();
            $.ajax({
                url:"{{url('auth/district')}}",
                type: 'post',
                data: {province_id : provinceId},
                success: function(result) {
                    var element='.district';
                    var html='<option value="">-- Chọn quận/huyện --</option>';
                  console.log(result.data);
                $.each(result.data, function(index, value){
                   html +="<option value='"+value.id+"'>"+value.name+"</option>";
                });
                $(element).html('').append(html);
                }
            });
        });
        $('.district').change(function(){
            let districtId = $(this).val();
            $.ajax({
                url:"{{url('auth/villages')}}",
                type: 'post',
                data: {district_id : districtId},
                success: function(result) {
                    var element_village='.village';
                    var html_village='<option value="">-- Chọn xã/phường --</option>';
                  console.log(result.data);
                $.each(result.data, function(index, value){ 
                   html_village +="<option value='"+value.id+"'>"+value.name+"</option>";
                });
                $(element_village).html('').append(html_village);
                }
            });
        });
    });
</script>
</body>
</html>
