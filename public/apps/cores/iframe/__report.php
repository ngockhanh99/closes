<!doctype html>
<html lang="vi" ng-app="myApp">
<head>
    <title><?php echo config("app.UNIT_NAME");?></title>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="icon" href="<?php echo asset('apps/cores/images') ?>/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="<?php echo url('theme') ?>/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/iCheck/flat/blue.css">
    <link href="<?php echo url('theme') ?>/plugins/iCheck/minimal/blue.css" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->

    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/morris/morris.css">
    <!--        <link rel="stylesheet" href="--><?php //echo url('theme') ?><!--/plugins/select2/morris.css">-->
    <!-- jvectormap -->

    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/select2/select2.css">

    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.css">
    <link rel="stylesheet"
          href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.theme.default.css">
    <!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/TableExport/5.0.0/css/tableexport.min.css">-->


    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/treeTable.css">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/style.css">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/print.css">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/questionFormKiosk.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.3 -->
    <script src="<?php echo url('theme') ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo url('theme') ?>/plugins/select2/select2.full.min.js"></script>
    <!-- readmoreJS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Readmore.js/2.2.0/readmore.min.js"></script>
    <script src="<?php echo url('theme') ?>/plugins/jquery-treetable/jquery.treetable.js"></script>

    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <!--        ghi âm-->
    <script src="<?php echo asset('js/recorder.js') ?>"></script>

    <!-- angularjs -->
    <script src="<?php echo asset('angularjs/angular.min.js') ?>"></script>

    <!--ui-route-->
    <script src="<?php echo asset('angularjs/angular-ui-router.min.js') ?>"></script>
    <!--paging-->
    <script src="<?php echo asset('angularjs/paging.js') ?>"></script>


    <!--app-angular-->
    <script src="<?php echo asset('apps/cores/views/iframe/module.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/route.js') ?>"></script>

    <script src="<?php echo asset('apps/cores/services.js') ?>"></script>

    <script>
        var SITE_ROOT = '<?php echo asset('/') ?>';
        var headerRequest = {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}};
        $(function () {
            HxUploadFiles.serverUpload = SITE_ROOT + 'rest/media/upload'
        });
    </script>
    <script src="<?php echo asset('vendor/laravel-filemanager/js') ?>/lfm.js"></script>

    <base href="<?php echo asset('/') ?>">
    <!--Login-->
    <script src="<?php echo asset('apps/cores/views/login/loginServices.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/views/iframe/js/report/reportCtrl.js') ?>"></script>


    <!--Directives-->
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <!--        <script src="-->

</head>
<body class="login-page">
<div id="reloadPage" ng-if="reloadPage">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
</div>
<div class="wrapper questionFormKiosk">
    <div class="row">
        <div class="col-xs-12">
            <section class="">
                <div class="row">
                    <div class="col-xs-12 ">
                        <div class=" box-primary">
                            <div class="box-body">
                                <h1>Cam Kết Của Chúng Tôi</h1>
                                <h2>1.Thu thập thông tin</h2>
                                Chúng tôi thu thập thông tin khi bạn đăng nhập vào tài khoản và xác nhận đồng ý cho phép hệ thống truy cập vào quyền hạn định vị và ghi âm bắt đầu cuộc khảo sát. Các thông tin thu thập là các nội dung trong phiếu khảo sát bao gồm thông tin đối tượng khảo sát, nội dung cuộc khảo sát. Chúng tôi sẽ tự động thu nhận và lưu trữ các thông tin như vị trí và ghi âm nội dung tại thời điểm bắt đầu khảo sát và chỉ kết thúc khi hoàn thành việc khảo sát.
                                Ngoài ra, hệ thống cũng lưu trữ thông tin máy tính và trình duyệt bao gồm địa chỉ IP, các thuộc tính phần mềm và phần cứng, và trang mà bạn yêu cầu truy cập khi đăng nhập.

                                <h2>2.Sử dụng thông tin</h2>
                                Bất kỳ thông tin chúng tôi thu thập từ bạn sẽ được dùng:
                                Thông tin cá nhân cơ bản: Để liên hệ nhằm nâng cao chất lượng dịch vụ
                                Định vị cuộc khảo sát: Để ghi nhận vị trí diễn ra cuộc khảo sát
                                Ghi âm nội dung khảo sát: Để người kiểm soát có thể xem lại nội dung khảo sát để tìm phương án nâng cao chất lượng dịch vụ
                                Kết quả khảo sát: Được sử dụng làm tài liệu chính xác để đánh giá dịch vụ của chúng tôi

                                <h2>3.Chính sách thương mại điện tử</h2>
                                Chúng tôi là người sở hữu duy nhất các thông tin được thu thập khi thực hiện cuộc khảo sát. Các thông tin cá nhân của bạn sẽ không được bán, trao đổi cho một bên thứ 3 nào nếu không có sự đồng ý từ người tham gia khảo sát ngoại trừ mục đích là liên hệ để cải thiện chất lượng cho người sử dụng dịch vụ của chúng tôi.


                                <h2>4.Thông cáo bên thứ 3</h2>
                                Chúng tôi không bán, giao thương hoặc chuyển đổi các thông tin cá nhân cho bên ngoài. Điều này không bao gồm các bên thứ 3 đáng tin cậy hỗ trợ chúng tôi vận hành trang web hoặc dịch vụ của chúng tôi khi mà các đối tác này cũng cam kết bảo mật các thông tin này.
                                Chúng tôi tin rằng việc chia sẽ thông tin là cần thiết trong các trường hợp để điều tra, ngăn chặn hoặc thực thi các biện pháp chống lại các hoạt động phạm pháp, gian lận đáng ngờ hoặc các tình huống có thể dẫn tới các nguy hiểm cho người dùng, các hành động vi phạm điều khoản sử dụng hay được yêu cầu bởi pháp luật.
                                Các thông tin không riêng tư mặt khác có thể được cung cấp cho bên thứ 3 nhằm mục đích quảng cáo, marketing hoặc mục đích khác.

                                <h2>5.Bảo mật thông tin</h2>
                                Chúng tôi ứng dụng nhiều biện pháp để bảo mật dữ liệu cá nhân người dùng. Cụ thể, chúng tôi sử dụng thuật toán mã hóa cao cấp để bảo mật các giao dịch trực tuyến đòi hỏi sự bảo vệ cao. Chỉ những nhân viên ở những vị trí riêng (ví dụ như người quản lý để làm rõ nội dung cuộc khảo sát phục vụ công tác nâng cao chất lượng dịch vụ) mới được quyền truy cập các thông tin cá nhân. Máy tính/các máy chủ dùng để lưu trữ các thông tin cá nhân đều được đặt ở môi trường khá bảo mật.
                                Chúng tôi không sử dụng cookies.

                                <h2>6.Hủy nhận thư</h2>
                                Chúng tôi không áp dụng hình thức gửi thư điện tử tự động đến người tham gia khảo sát.


                                <h2>7.Đồng ý</h2>
                                Bằng cách sử dụng ứng dụng của chúng tôi, bạn đã đồng ý với chính sách riêng tư của chúng tôi.
                            </div>
                        </div>
                    </div>
                </div>
                <!--And add new from question-->
        </div>
        </section>
    </div>
</div>
<!--And add new from question-->

<!-- jQuery UI 1.11.4 -->
<script src="<?php echo url('js') ?>/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo url('theme') ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo url('bootstrap') ?>/plugins/bootstrap-treeview.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo url('js') ?>/raphael-min.js"></script>
<script src="<?php echo url('theme') ?>/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo url('theme') ?>/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?php echo url('theme') ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo url('theme') ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="<?php echo url('theme') ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- daterangepicker -->
<script src="<?php echo url('js') ?>/moment.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo url('theme') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Slimscroll -->
<script src="<?php echo url('theme') ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="<?php echo url('theme') ?>/plugins/fastclick/fastclick.js"></script>

<!--notifyjs-->
<script src="<?php echo url('theme') ?>/plugins/notifyjs/notify.min.js"></script>

<!--bootstrap notify-->
<script src="<?php echo url('js') ?>/bootstrap-notify.js"></script>

<!-- bootbox.js -->
<script src="<?php echo url('theme') ?>/plugins/bootbox/bootbox.js"></script>

<script src="<?php echo url('theme') ?>/plugins/select2/select2.full.min.js"></script>


<!-- datepicker -->
<script src="<?php echo url('theme') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo url('theme') ?>/plugins/datepicker/locales/bootstrap-datepicker.vi.js"></script>


<!--upload file-->
<script src="<?php echo url('js') ?>/hx_upload.js"></script>

<!--ocLazyLoad-->
<script src="<?php echo url('js') ?>/ocLazyLoad/dist/ocLazyLoad.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo url('theme') ?>/dist/js/app.min.js"></script>
</body>
</html>
