<html>
<head>
    <title>{{ isset($senderName) ? $senderName : '' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">{{ file_get_contents(app_path() . '/../vendor/snowfire/beautymail/src/styles/css/ark.css') }}</style>


</head>
<body>
<table id="background-table" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <tr>
        <td align="center">
            <table class="w640" border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody>
                <tr class="large_only">
                    <td class="w640" height="20" width="640"></td>
                </tr>
                <tr class="mobile_only">
                    <td class="w640" height="10" width="640"></td>
                </tr>
                <tr class="mobile_only">
                    <td class="w640" width="640" align="center">
                        {{--                        <img class="mobile_only" border="0" src="{{ array_key_exists('path', $logo) ? $logo['path'] : '' }}" alt="{{ isset($senderName) ? $senderName : '' }}" width="{{ array_key_exists('width', $logo) ? $logo['width'] : '' }}" height="{{ array_key_exists('height', $logo) ? $logo['height'] : '' }}" />--}}
                    </td>
                </tr>
                <tr class="mobile_only">
                    <td class="w640" height="10" width="640"></td>
                </tr>
                <tr class="large_only">
                    <td class="w640" bgcolor="#d46f1d" height="10" width="820"></td>
                </tr>
                <tr class="mobile_only">
                    <td class="w640" bgcolor="#d46f1d" height="10" width="640"></td>
                </tr>
                <tr>
                    <td id="header" class="w640" align="center" bgcolor="#d46f1d" width="640">
                        <table class="w640" border="0" cellpadding="0" cellspacing="0" width="640">
                            <tr style="text-align: center">
                                <td id="logo" width="100" valign="top">
                                    <img border="0" style="margin: 0 auto"
                                         src="<?php echo asset('apps/cores/images') ?>/logo-SonLa.png"
                                         width="60px" height="60px"/>
                                </td>
                                <td>
                                    <h1 style="text-align: right; margin-right: 62.5px; color: #ffffff;"><?php echo config("app.UNIT_NAME");?></h1>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="10" class="large_only"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td class="w640" bgcolor="#ffffff" width="640">
                        <table class="w640" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>

                            <tr>
                                <td class="w560" width="560">
                                    <table class="w560" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr class="large_only">
                                            <td class="w560" height="50" width="560"></td>
                                        </tr>
                                        <tr>
                                            <td class="w560" width="560">
                                                <div class="article-content" align="center">
                                                    <h1 style="text-align: center">Thông báo nhập kết quả chỉ số hài lòng thấp</h1>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td class="w560" width="560">
                                    <table class="w560" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td class="w560" height="15" width="560"></td>
                                        </tr>
                                        <tr>
                                            <td class="w560" width="560">
                                                <div class="article-content" align="left">
                                                    <h4 class="secondary"
                                                        style="margin-left: 30px; margin-right: 30px">
                                                        Phiếu khảo sát có số TT phiếu: <b>"{{$data['questionFormInfo']->index}}"</b>
                                                        do <b>{{$user['user_name']}}</b>
                                                        nhập lúc <i>{{date('d-m-Y h:i', strtotime($data['questionFormInfo']->created_at)) }}</i>
                                                         cho đơn vị <b>{{$data['ouInfo']->ou_name}}</b> đạt chỉ số hài lòng là:
                                                        <span style="color: red;">{{$data['satisfaction_index']}}%</span>
                                                    </h4>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="60"></td>
                            </tr>

                            <tr style="text-align: center">
                                <td style="text-align: center;border-radius:4px;">
                                    <a href="<?php echo config("app.url");?>"
                                       style="background:#f48024;border:1px solid #f48024;font-family:arial,sans-serif;font-size:17px;line-height:17px;color:#ffffff;text-align:center;text-decoration:none;padding:13px 17px;margin:auto;border-radius:4px;white-space:nowrap"
                                       target="_blank">Xem kết quả đánh giá
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="30"></td>
                            </tr>
                            <tr>
                                <td colspan="3" height="100" style="text-align: left;">
                                    <h3 style=" margin-left: 30px">Trân trọng,</h3>
                                    <h3 style=" margin-left: 30px"><strong><?php echo config("app.UNIT_NAME");?></strong></h3>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="w640" bgcolor="#ffffff" width="640" colspan="3" height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="640" class="w640" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="w50" width="50"></td>
                                <td class="w410" width="410">
                                </td>
                                <td valign="top">
                                    <table align="right">
                                        <tr>
                                            <td colspan="2" height="10"></td>
                                        </tr>
                                        <tr>
{{--                                            <td><a href="https://twitter.com/ha_van_linh"><img--}}
{{--                                                            src="http://localhost/par_index_v2/vendor/beautymail/assets/images/ark/twitter.png"--}}
{{--                                                            alt="Twitter" height="25" width="25" style="border:0"/></a>--}}
{{--                                            </td>--}}

{{--                                            <td><a href="https://facebook.com/havanlinh2011"><img--}}
{{--                                                            src="http://localhost/par_index_v2/vendor/beautymail/assets/images/ark/twitter.png"--}}
{{--                                                            alt="Facebook" height="25" width="25" style="border:0"/></a>--}}
{{--                                            </td>--}}
                                        </tr>
                                    </table>
                                </td>
                                <td class="w15" width="15"></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="w640" height="90" width="640">
                        <div style="text-align: center">
                            <h2 style="font-size:14px; margin:5px"> <b>Đơn vị quản lý:</b> <?php echo config("app.FOOTER_UNIT");?></h2>
                            <h2 style="font-size:14px; margin:5px"> <b>Địa chỉ:</b> <?php echo config("app.FOOTER_ADDRESS");?></h2>
                            <h2 style="font-size:14px; margin:5px"><b> ĐT</b>: <?php echo config("app.FOOTER_PHONE");?></h2>
                            <h2 style="font-size:14px; margin:5px"> <b>E-mail</b>: <?php echo config("app.FOOTER_EMAIL");?></h2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="w15" width="15"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
