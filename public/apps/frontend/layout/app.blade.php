<!doctype html>
<html lang="vi" ng-app="myApp">

<head>
    <title><?php echo config("app.UNIT_NAME"); ?></title>
    <meta name="csrf-token" content="<?php echo csrf_token() ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="<?php echo asset('apps/frontend/images') ?>/hnd_logo.png" type="image/x-icon" />
    <link href="<?php echo url('theme/skote') ?>/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Bootstrap Rating css -->
    <link href="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-rating/bootstrap-rating.css" rel="stylesheet"
        type="text/css" />
    <link href="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
        rel="stylesheet" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme/skote') ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->  <!-- Sweet Alert-->
        <link href="<?php echo url('theme/skote') ?>/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo url('theme/skote') ?>/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="<?php echo asset('apps/frontend/css') ?>/style.css">
    @stack('css')
</head>

<body>
    <div class="wrapper">
        @include('frontend.layout.header')
        @yield('content')
        @include('frontend.layout.footer')
    </div>
    <script>
    const SITE_ROOT = '{{asset('/')}}'
    </script>

    <script src="<?php echo url('theme/skote') ?>/assets/libs/jquery/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{asset('apps/frontend/js/slide.js')}}"></script>
    <!-- JAVASCRIPT -->
    <script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-rating/bootstrap-rating.min.js"></script>

    <script src="<?php echo url('theme/skote') ?>/assets/js/pages/rating-init.js"></script>
    <!-- Bootrstrap touchspin -->
    <script src="<?php echo url('theme/skote') ?>/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js">
    </script>

    <script src="<?php echo url('theme/skote') ?>/assets/js/pages/ecommerce-cart.init.js"></script>
      <!-- Sweet Alerts js -->
      <script src="<?php echo url('theme/skote') ?>/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="https://unpkg.com/ionicons@latest/dist/ionicons.js"></script>
    @stack('js')
</body>

</html>