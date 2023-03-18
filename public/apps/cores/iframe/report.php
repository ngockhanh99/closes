<!doctype html>
<html lang="vi" ng-app="myApp">

<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo config("app.UNIT_NAME"); ?></title>
    <!-- App favicon -->
    <link rel="icon" href="<?php echo asset('apps/cores/images') ?>/hnd_logo.png" type="image/x-icon"/>

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
          type="text/css"/>
    <!-- Icons Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/datepicker/datepicker3.css">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?php echo url('theme/skote') ?>/assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet"
          href="<?php echo url('theme/skote') ?>/assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <script src="<?php echo url('theme/skote') ?>/assets/libs/jquery/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo url('theme') ?>/plugins/select2/select2.full.min.js"></script>
    <script src="<?php echo url('theme') ?>/plugins/select2/select2-searchInputPlaceholder.js"></script>
    <!-- readmoreJS-->
    <script src="<?php echo url('js') ?>/readmore.min.js"></script>
    <!--    CkEditor-->
    <script src="<?php echo url('js/ckeditor') ?>/ckeditor.js"></script>

    <!-- Responsive Table css -->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/admin-resources/rwd-table/rwd-table.min.css"
          rel="stylesheet" type="text/css"/>
    <!-- Sweet Alert-->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
          type="text/css"/>
    <!--touchspin-->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.css">
    <link rel="stylesheet"
          href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.theme.default.css">
    <!-- DataTables -->
    <link rel="stylesheet"
          href="<?php echo url('theme/skote') ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <!-- App Css-->
    <link href="<?php echo url('theme/skote') ?>/assets/css/app.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/treeTable.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/style.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/print.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/enterAnswerSipas.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/responsive.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/chat-realtime.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/block-product.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/mca.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/style_timeline.css?v=<?php echo config('app.version') ?>">
    <!-- angularjs -->
    <script src="<?php echo asset('js/recorder.js') ?>"></script>
    <!--    js helper-->
    <script src="<?php echo asset('js/jsHelper.js') ?>"></script>
    <script src="<?php echo asset('angularjs/angular.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/animate/angular-animate.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/angular-ui-router.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/paging5.js') ?>"></script>

    <script src="<?php echo asset('apps/cores/iframe/module.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/iframe/route.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/services.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/iframe/js/reportCtrl.js') ?>"></script>
    <script>
        var SITE_ROOT = '<?php echo asset('/') ?>';
        var APP_VERSION = '<?php echo config('app.version') ?>';
        var headerRequest = {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        };
    </script>

    <!--    // Apex chart-->
    <script src="<?php echo asset('theme/plugins/apexcharts/dist/apexcharts.min.js') ?>"></script>
    <script src="<?php echo asset('vendor/laravel-filemanager/js') ?>/lfm.js"></script>
    <!--Login-->
    <script src="<?php echo asset('apps/cores/views/components/login/loginServices.js') ?>"></script>
    <!--    Filters angularjs-->
    <script src="<?php echo asset('apps/cores/views/filters/angular_filters.js') ?>"></script>

</head>

<body data-topbar="light" ng-cloak="">
<div id="layout-wrapper" ng-controller="reportCtrl">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Sản lượng sản xuất</h5>
            <div class="row" style="margin-top: 45px;">
                <div class="col-md-8">
                    <div id="stacked-column-chart"></div>
                </div>
                <div class="col-md-4">
                    <div id="polar-area-charts"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Nhu cầu sản phẩm</h5>
            <div class="row" style="margin-top: 45px;">
                <div class="col-md-8">
                    <div id="stacked-column-chart-2"></div>
                </div>
                <div class="col-md-4">
                    <div id="polar-area-charts-2"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JAVASCRIPT -->
<script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/node-waves/waves.min.js"></script>

<script src="<?php echo url('theme/skote') ?>/assets/js/app.js"></script>
<!-- daterangepicker -->
<script src="<?php echo url('js') ?>/moment.min.js"></script>
<!-- Responsive Table js -->
<script src="<?php echo url('theme/skote') ?>/assets/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

<!-- datepicker -->
<script src="<?php echo url('theme') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo url('theme') ?>/plugins/datepicker/locales/bootstrap-datepicker.vi.js"></script>
<script
        src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- bootbox.js -->
<script src="<?php echo url('theme') ?>/plugins/bootbox/bootbox.js"></script>
<!--notifyjs-->
<script src="<?php echo url('theme') ?>/plugins/notifyjs/notify.min.js"></script>

<!--bootstrap notify-->
<script src="<?php echo url('js') ?>/bootstrap-notify.js"></script>

<!-- Sweet Alerts js -->
<script src="<?php echo url('theme/skote') ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo url('theme') ?>/plugins/jquery-treetable/jquery.treetable.js"></script>
<script src="<?php echo url('theme') ?>/plugins/html5_gallery/html5gallery.js"></script>

<script src="<?php echo url('theme') ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--upload file-->
<script src="<?php echo url('js') ?>/hx_load_excel.js"></script>
<script src="<?php echo url('js') ?>/hx_upload.js"></script>
<script src="<?php echo url('theme/skote') ?>/assets/libs/owl.carousel/owl.carousel.min.js"></script>

<!-- timeline init js -->
<script src="<?php echo url('theme/skote') ?>/assets/js/pages/timeline.init.js"></script>


<!--ocLazyLoad-->
<script src="<?php echo url('js') ?>/ocLazyLoad/dist/ocLazyLoad.js"></script>
</body>

</html>
