<!doctype html>
<html lang="vi" ng-app="myApp">
<head>
    <title><?php echo config("app.UNIT_NAME");?></title>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="icon" href="<?php echo asset('apps/cores/images') ?>/hnd_logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="<?php echo url('theme') ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo url('theme') ?>/bootstrap/css/dataTables.bootstrap4.min.css">
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
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/enterAnswerSipas.css">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/responsive.css">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/chat-realtime.css">


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

<!--    js helper-->
    <script src="<?php echo asset('js/jsHelper.js') ?>"></script>
<!--    ckeditor-->
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>

<!--    <script type="text/javascript"  src="https://maps.google.com/maps/api/js?key=--><?php //echo env('GOOGLE_API_KEY', '') ?><!--"></script>-->
    <!-- angularjs -->
    <script src="<?php echo asset('angularjs/angular.min.js') ?>"></script>

    <!--ui-route-->
    <script src="<?php echo asset('angularjs/angular-ui-router.min.js') ?>"></script>
    <!--paging-->
    <script src="<?php echo asset('angularjs/paging.js') ?>"></script>

    <!--app-angular-->
    <script src="<?php echo asset('apps/cores/module.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/route/route.js') ?>?<?php echo time() ?>"></script>
    <script src="<?php echo asset('apps/cores/route/routeMCA.js') ?>?<?php echo time() ?>"></script>

    <script src="<?php echo asset('apps/cores/services.js') ?>"></script>

    <script>
        var SITE_ROOT = '<?php echo asset('/') ?>';
        var headerRequest = {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}};
        $(function () {
            HxUploadFiles.serverUpload = SITE_ROOT + 'rest/media/upload'
        });
    </script>
    <script>
        var route_prefix = "<?php echo config('lfm.url_prefix') ?>";
        var url_view_file = "<?php echo config('constants.url_view_file') ?>";
    </script>
    <script src="<?php echo asset('vendor/laravel-filemanager/js') ?>/lfm.js"></script>

    <base href="<?php echo asset('/') ?>">
    <!--Login-->
    <script src="<?php echo asset('apps/cores/views/components/login/loginServices.js') ?>"></script>
    <!--End login-->

<!--    Filters angularjs-->
    <script src="<?php echo asset('apps/cores/views/filters/angular_filters.js')?>"></script>

    <!--Directives-->
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script src="<?php echo asset('apps/cores/views/components/notification/notificationServices.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/views/components/header/headerCtrl.js') ?>"></script>
    <!--        <script src="-->
    <script src="<?php echo asset('apps/cores/views/directives/asideLeft/asideLeftDirective.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/views/directives/paginate/paginateDirective.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/views/directives/formatInputNumber/formatInputNumber.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/views/directives/showMore/showMore.js') ?>"></script>

</head>
<body class="skin-blue sidebar-mini <?php echo config("app.THEME_APP") == 'green' ? 'skin-green-light' : 'skin-yellow-light' ?>" ng-class="{'overflow-hidden': fullScreen}">
<div id="reloadPage" ng-if="reloadPage">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
</div>
<div class="wrapper">
    <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'header' . DIRECTORY_SEPARATOR . 'header.php';
    ?>
    <aside-left></aside-left>
    <div class="content-wrapper" style="margin-left: 250px;">
        <div ui-view></div>
    </div>
    <footer class="main-footer">
        <div class="row">
            <div class="col-md-8">
                <h2 style="font-size:14px; margin:5px"> <b>Đơn vị quản lý:</b> <?php echo config("app.FOOTER_UNIT");?></h2>
                <h2 style="font-size:14px; margin:5px"> <b>Địa chỉ:</b> <?php echo config("app.FOOTER_ADDRESS");?></h2>
                <h2 style="font-size:14px; margin:5px"><b> ĐT</b>: <?php echo config("app.FOOTER_PHONE");?></h2>
                <h2 style="font-size:14px; margin:5px"> <b>E-mail</b>: <?php echo config("app.FOOTER_EMAIL");?></h2>
            </div>
            <div class="col-md-4 text-right">
                <?php if(config("app.SHOW_APP_MOBILE")): ?>
                    <a href="https://play.google.com/store/apps/details?id=com.DNkhaosat" target="_blank">
                        <img src="apps/cores/images/googlePlay.png" style="max-width: 100%;">
                    </a>
    <!--                <br/>-->
                    <a href="https://apps.apple.com/us/app/khao-sat-dich-vu/id1521203101" target="_blank">
                        <img src="apps/cores/images/appStore.png" style="max-width: 100%;">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </footer>
</div>


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


<!-- datepicker -->
<script src="<?php echo url('theme') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo url('theme') ?>/plugins/datepicker/locales/bootstrap-datepicker.vi.js"></script>
<!--apexcharts-->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Socket IO -->
<script src="<?php echo url('js') ?>/socket.io-client-4.4.1/dist/socket.io.js"></script>

<!--upload file-->
<script src="<?php echo url('js') ?>/hx_upload.js"></script>
<script src="<?php echo url('js') ?>/hx_load_excel.js"></script>

<!--ocLazyLoad-->
<script src="<?php echo url('js') ?>/ocLazyLoad/dist/ocLazyLoad.js"></script>


<!-- AdminLTE App -->
<script src="<?php echo url('theme') ?>/dist/js/app.min.js"></script>
</body>
</html>
