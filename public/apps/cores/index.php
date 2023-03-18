<!doctype html>
<html lang="vi" ng-app="myApp">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo config("app.UNIT_NAME"); ?></title>
    <!-- App favicon -->
    <link rel="icon" href="<?php echo asset('apps/cores/images') ?>/hnd_logo.png" type="image/x-icon" />

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
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
        rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />
    <!--touchspin-->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.css">
    <link rel="stylesheet"
        href="<?php echo url('theme') ?>/plugins/jquery-treetable/css/jquery.treetable.theme.default.css">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="<?php echo url('theme/skote') ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <!-- App Css-->
    <link href="<?php echo url('theme/skote') ?>/assets/css/app.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/treeTable.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/style.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/print.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/enterAnswerSipas.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/responsive.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/chat-realtime.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/block-product.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet" href="<?php echo asset('apps/cores/css') ?>/mca.css?v=<?php echo config('app.version') ?>">
    <link rel="stylesheet"
        href="<?php echo asset('apps/cores/css') ?>/style_timeline.css?v=<?php echo config('app.version') ?>">
    <!-- angularjs -->
    <script src="<?php echo asset('js/recorder.js') ?>"></script>
    <!--    js helper-->
    <script src="<?php echo asset('js/jsHelper.js') ?>"></script>
    <script src="<?php echo asset('angularjs/angular.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/animate/angular-animate.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/angular-ui-router.min.js') ?>"></script>
    <script src="<?php echo asset('angularjs/paging5.js') ?>"></script>

    <script src="<?php echo asset('apps/cores/module.js') ?>"></script>
    <script src="<?php echo asset('apps/cores/route/route.js') ?>?v=<?php echo config('app.version') ?>"></script>
    <script src="<?php echo asset('apps/cores/route/routeDochoi.js') ?>?v=<?php echo config('app.version') ?>"></script>
    <script src="<?php echo asset('apps/cores/services.js') ?>"></script>
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

    <script src="<?php echo asset('apps/cores/views/components/notification/notificationServices.js') ?>"></script>
    <script
        src="<?php echo asset('apps/cores/views/components/header/headerCtrl.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <!--        <script src="-->
    <script
        src="<?php echo asset('apps/cores/views/directives/asideLeft/asideLeftDirective.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <script
        src="<?php echo asset('apps/cores/views/directives/paginate/paginateDirective.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <script
        src="<?php echo asset('apps/cores/views/directives/formatInputNumber/formatInputNumber.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <script
        src="<?php echo asset('apps/cores/views/directives/showMore/showMore.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <script
        src="<?php echo asset('apps/cores/views/directives/purchaseAsk/purchaseAskReceived/purchaseAskReceived.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
    <script
        src="<?php echo asset('apps/cores/views/directives/purchaseAsk/purchaseAskSent/purchaseAskSent.js') ?>?v=<?php echo config('app.version') ?>">
    </script>
</head>

<body data-topbar="light" ng-cloak="">
    <div id="reloadPage" ng-if="reloadPage">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'header' . DIRECTORY_SEPARATOR . 'header.php';
    ?>
        <!-- ========== Left Sidebar Start ========== -->
        <aside-left></aside-left>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div ui-view></div>
            </div>
            <!-- End Page-content -->

            <footer class="footer" style="height: 150px;">
                <div class="row">
                    <div class="col-md-8">
                        <h2 style="font-size:14px; margin:5px"><b>Đơn vị quản
                                lý:</b> <?php echo config('app.FOOTER_UNIT'); ?></h2>
                        <h2 style="font-size:14px; margin:5px"><b>Địa chỉ:</b>
                            <?php echo config('app.FOOTER_ADDRESS'); ?>
                        </h2>
                        <h2 style="font-size:14px; margin:5px"><b> ĐT</b>: <?php echo config('app.FOOTER_PHONE'); ?>
                        </h2>
                        <h2 style="font-size:14px; margin:5px"><b>E-mail</b>: <?php echo config('app.FOOTER_EMAIL'); ?>
                        </h2>
                        <h2 style="font-size:14px; margin:5px"><b>ĐT Hỗ
                                trợ</b>: <?php echo config('app.FOOTER_PHONE_SUPPORT'); ?></h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <?php if (config('app.SHOW_APP_MOBILE')) : ?>
                        <a href="apps/cores/appMobile/khaosat.apk" target="_blank">
                            <img src="apps/cores/images/googlePlay.png" style="max-width: 100%;">
                        </a>
                        <!--                <br/>-->
                        <a href="apps/cores/appMobile/khaosat.apk" target="_blank">
                            <img src="apps/cores/images/appStore.png" style="max-width: 100%;">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Cài đặt</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Chọn bố cục</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="<?php echo url('theme/skote') ?>/assets/images/layouts/layout-1.jpg" class="img-thumbnail"
                        alt="layout images">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Chế độ sáng</label>
                </div>

                <div class="mb-2">
                    <img src="<?php echo url('theme/skote') ?>/assets/images/layouts/layout-2.jpg" class="img-thumbnail"
                        alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                    <label class="form-check-label" for="dark-mode-switch">Chế độ tối</label>
                </div>

                <div class="mb-2">
                    <img src="<?php echo url('theme/skote') ?>/assets/images/layouts/layout-3.jpg" class="img-thumbnail"
                        alt="layout images">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                    <label class="form-check-label" for="rtl-mode-switch">Chế độ sáng menu bên phải</label>
                </div>

                <div class="mb-2">
                    <img src="<?php echo url('theme/skote') ?>/assets/images/layouts/layout-4.jpg" class="img-thumbnail"
                        alt="layout images">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                    <label class="form-check-label" for="dark-rtl-mode-switch">Chế độ tối menu bên phải</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->
    <!-- right offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-pdf" tabindex="-1" id="offcanvasViewPdf" data-bs-scroll="true"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Xem file PDF</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <object data="{{rootFilePathPdf}}" type="application/pdf" width="100%" ng-if="rootFilePathPdf"
                height="850px">
                <embed src="{{rootFilePathPdf}}" type="application/pdf" />
            </object>
        </div>
    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

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
    <script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js">
    </script>

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