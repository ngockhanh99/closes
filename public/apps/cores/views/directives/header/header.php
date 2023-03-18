<header class="main-header">
    <style>
        .un_read {
            background-color: #f4f4f4;
        }

        }
    </style>
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>PI</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <span class="img-logo-sonla">&nbsp;&nbsp;&nbsp;</span>
            <b>P</b>arindex
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-left text-uppercase text-center d-sm-none">
            <b>Phần mềm quản lý chấm điểm xác định chỉ số cải cách hành chính</b>
        </div>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a ng-click="actions.resetNotificationCount()" href="" class="dropdown-toggle"
                       data-toggle="dropdown">
                        <i class="fa fa-lg fa-bell" style="font-size: 150%"></i>
                        <span class="label label-info notifi">{{data.count_new_notification > 0 ? data.count_new_notification : ''}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!--                        <li class="header">Bạn có {{data.count_new_notification}} thông báo</li>-->
                        <li>
                            <div class="slimScrollDiv"
                                 style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                    <li ng-repeat="notify in data.notification" class="pointer">
                                        <a ng-class="notify.read_at ? '' : 'un_read' "
                                           ng-click="actions.showDetail(notify)">
                                            <i class="fa fa-info-circle text-blue"></i> {{notify.data['content']}}
                                        </a>
                                    </li>
                                </ul>
                                <div class="slimScrollBar"
                                     style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div>
                                <div class="slimScrollRail"
                                     style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                            </div>
                        </li>
                        <li class="footer"><a href="#!/notification">Xem tất cả</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
<!--                <li class="dropdown notifications-menu">-->
<!--                    <a href="apps/cores/guide/HDSD-Sipas.pdf" target="_blank" title="Hướng dẫn sử dụng phần mềm">-->
<!--                        <i class="fa fa-lg fa-question" style="font-size: 150%"></i>-->
<!--                    </a>-->
<!--                </li>-->

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i ng-if="!userInfo.user_avatar" class="fa fa-lg fa-user"></i>
                        <img ng-if="userInfo.user_avatar" ng-src="{{userInfo.user_avatar}}" class="user-image"
                             alt="User Image">
                        <span class="hidden-xs">
                            {{userInfo.user_name}}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <i ng-if="!userInfo.user_avatar" class="fa fa-user"
                               style="font-size: 100px;color: white"></i>
                            <img ng-if="userInfo.user_avatar" ng-src="{{userInfo.user_avatar}}" class="img-circle"
                                 alt="User Image">
                            <p>
                                {{userInfo.user_name}}
                                <small>{{userInfo.user_email}}</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="javascript:;" class="btn btn-default btn-flat"
                                   ng-click="actions.showModalChangePassword()">Đổi mật khẩu</a>
                            </div>
                            <div class="pull-right">
                                <a href="javascript:;" ng-click="actions.logout()" class="btn btn-default btn-flat">Đăng
                                    xuất</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
<div id="fullScreen" ng-show="fullScreen">
    <button type="button" class="btn btn-box-tool html-hide-full-screen" ng-click="hideFullScreen()">
        <i class="fa fa-compress"></i>
    </button>
    <div id="dataFullScreen" ng-bind-html="dataFullScreen"></div>
</div>
<!-- Modal Thay đổi mật khẩu -->
<div class="modal fade" id="changePassword" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header style-changePass" style="background-color: #00a7d0;color: #fff;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ">Thay đổi mật khẩu</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
<!--                    <div class="form-group row text-center"-->
<!--                         ng-class="errors.changePasswordInfo.message ? 'has-error' : ''">-->
<!--                        <span class="help-block color-error">{{errors.changePasswordInfo.error}}</span>-->
<!--                    </div>-->
                    <div class="form-group" ng-class="errors.changePasswordInfo.password_old ? 'has-error' : ''">
                        <label class="col-sm-3 control-label">Mật khẩu cũ : <span
                                    style="color: #d81b1b">*</span></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" ng-model="changePasswordInfo.password_old">
                            <span class="help-block" style="color: red"
                                  ng-repeat="error in errors.changePasswordInfo.password_old">{{error}}</span>
                        </div>
                    </div>
                    <div class="form-group" ng-class="errors.changePasswordInfo.password ? 'has-error' : ''">
                        <label class="col-sm-3 control-label">Mật khẩu mới : <span
                                    style="color: #d81b1b">*</span></label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" ng-model="changePasswordInfo.password">
                            <span class="help-block" style="color: red"
                                  ng-repeat="error in errors.changePasswordInfo.password">{{error}}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nhập lại mật khẩu : </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control"
                                   ng-model="changePasswordInfo.password_confirmation">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-primary" ng-click="actions.changePassword()">Đổi mật khẩu
                    </button>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="modal  fade" id="notificationDetail" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <!--            <div class="modal-header style-changePass" style="background-color: #00a7d0;color: #fff;">-->
            <div class="modal-header style-changePass">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ">Thông báo</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <colgroup>
                        <col width="50px"></col>
                        <col width="150px"></col>
                        <col width="50%"></col>
                        <col width="30%"></col>
                    </colgroup>
                    <tr class="table-green">
                        <th>Thời gian</th>
                        <th class="text-center">Người gửi</th>
                        <th class="text-center">Nội dung</th>
                        <th class="text-center">Tài liệu đính kèm</th>
                    </tr>
                    <tr>
                        <td>{{actions.formatDateTime(data.active_notify.created_at)}}</td>
                        <td>{{data.active_notify.created_by_username}}</td>
                        <td>{{data.active_notify.data['content']}}</td>
                        <td>
                            <a class="display-block print-hide" ng-repeat-start="file in data.active_notify.files"
                               href="{{actions.getPath(file.filepath)}}"
                               target="_blank">- {{file.filename}}
                            </a>
                            <small ng-repeat-end><i>được tải lên bởi {{file.user_name}} vào
                                    {{actions.formatDateTime(file.created_at)}} </i></small>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>

