<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Trang không tồn tại</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo url('theme') ?>/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <style>
        html {
            background: #f9fafc;
            height: 100%;
        }

        main-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            margin: 0px;
        }

        .main-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            margin: 0px;
        }
    </style>
</head>
<body class="hold-transitionskin-blue sidebar-mini skin-yellow-light"  >
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div style=" height: -webkit-fill-available">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content" style=" padding-top: 100px">

            <div class="error-page">
                <h2 class="headline text-yellow">503</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Dịch vụ không khả dụng</h3>

                    <p>
                        Vui lòng quay lại sau.<br>
                        <a href="<?php echo url('') ?>" >Quay lại trang chủ</a>
                    </p>

                    <form class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm">

                            <div class="input-group-btn">
                                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                    </form>
                </div>
            </div>
            <!-- /.error-page -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer" style="margin-left: 0px !important;">
        <div style="text-align: center">
            <h2 style="font-size:14px; margin:5px"> <b>Đơn vị quản lý:</b> <?php echo config("app.FOOTER_UNIT");?></h2>
            <h2 style="font-size:14px; margin:5px"> <b>Địa chỉ:</b> <?php echo config("app.FOOTER_ADDRESS");?></h2>
            <h2 style="font-size:14px; margin:5px"><b> ĐT</b>: <?php echo config("app.FOOTER_PHONE");?></h2>
            <h2 style="font-size:14px; margin:5px"> <b>E-mail</b>: <?php echo config("app.FOOTER_EMAIL");?></h2>
        </div>
    </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo url('theme') ?>/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo url('theme') ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo url('theme') ?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo url('theme') ?>/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo url('theme') ?>/dist/js/demo.js"></script>
</body>
</html>
