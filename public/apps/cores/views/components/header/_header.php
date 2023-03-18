<div ng-controller="headerCtrl">

    <header class="main-header height-header">
        <style>
            .un_read {
                background-color: #f4f4f4;
            }

            }
        </style>
        <!-- Logo -->
        <a href="#" class="logo height-header">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>PI</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">
                <span class="img-logo-sonla">&nbsp;&nbsp;&nbsp;</span>
                <!-- <?php echo config("app.UNIT_NAME"); ?> -->
            </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top height-header">
            <!-- Sidebar toggle button-->
            <a href="" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-left text-uppercase text-center d-sm-none div-header">
                <a href=""><img src="apps/cores/images/hnd_logo.png" alt="" width="60px" height="60px" style="margin-top: 5px;"></a>
                <div class="text-header">
                    <b class="full-name-header"><?php echo config("app.APP_FULL_NAME"); ?></b>
                    <p class="title-header">bac giang farmer’s union</p>
                </div>
            </div>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav" style="margin-top: 5px;">
                    <li ng-if="<?php echo config("app.CHAT_REALTIME") ?>">
                        <a href="">
                            <i class="fa fa-comments-o" style="font-size: 150%" ng-click="actions.goToChat()">
                                <span class="{{$root.alertChat?'dot-unread':''}}" style="top:12px;"></span>
                            </i>
                        </a>

                    </li>

                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a ng-click="actions.resetNotificationCount()" href="" class="dropdown-toggle" data-toggle="dropdown" >
                            <i class="fa fa-lg fa-bell" style="font-size: 150%"></i>
                            <span class="label label-info notifi">{{data.count_new_notification > 0 ? data.count_new_notification : ''}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!--                        <li class="header">Bạn có {{data.count_new_notification}} thông báo</li>-->
                            <li>
                                <div class="slimScrollDiv">
                                    <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                        <li ng-repeat="notify in data.notification" class="pointer">
                                            <a ng-class="notify.read_at ? '' : 'un_read' " ng-click="actions.showDetail(notify)">
                                                <i class="fa fa-info-circle text-blue"></i> {{notify.data['content']}}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div>
                                    <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                                </div>
                            </li>
                            <li class="footer"><a href="#!/notification">Xem tất cả</a></li>
                        </ul>
                    </li>

                    <?php if (config("app.SHOW_HELP")) : ?>
                        <li class="dropdown notifications-menu">
                            <a href="apps/cores/guide/HDSD-phan-mem.pdf" target="_blank" title="Hướng dẫn sử dụng phần mềm">
                                <i class="fa fa-lg fa-question" style="font-size: 150%"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu" style="margin-left: -15px;">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i ng-if="!userInfo.user_avatar" class="fa fa-lg fa-user"></i>
                            <img ng-if="userInfo.user_avatar" ng-src="{{userInfo.user_avatar}}" class="user-image" alt="User Image">
                            <span class="hidden-xs" >
                                {{userInfo.user_name}}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <i ng-if="!userInfo.user_avatar" class="fa fa-user" style="font-size: 100px;color: white"></i>
                                <img ng-if="userInfo.user_avatar" ng-src="{{userInfo.user_avatar}}" class="img-circle" alt="User Image">
                                <p>
                                    {{userInfo.user_name}}
                                    <small>{{userInfo.user_email}}</small>
                                </p>
                            </li>

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left" ng-if="!userInfo.root_ou_id">
                                    <a href="javascript:;" class="btn btn-default btn-flat" ng-click="actions.showModalChangePassword()">Cập nhật thông tin</a>
                                </div>
                                <div class="pull-left" ng-if="userInfo.root_ou_id">
                                    <a href="#!/update-my-profile" class="btn btn-default btn-flat">Thông tin doanh nghiệp</a>
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
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header style-changePass" style="background-color: #00a7d0;color: #fff;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title ">Cập nhật thông tin</h4>
                </div>
                <div class="modal-body" style="height: 70vh;overflow: auto;">

                    <div class="change-profile">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Tên Doanh nghiệp/Tổ chức<span style="color:red">*</span></label>
                                <input ng-model="myProfile.enterprise_name" class="form-control">
                                <span style="color:red;">{{errors.enterprise_name[0]}}</span>
                            </div>
                            <div class="col-md-6">
                                <label>Email (Tên đăng nhập)<span style="color:red">*</span></label>
                                <input ng-model="myProfile.user_email" disabled class="form-control">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Mật khẩu mới</label>
                                <input type="password" ng-model="myProfile.password" class="form-control">
                                <span style="color:red;">{{errors.password[0]}}</span>
                            </div>
                            <div class="col-md-6">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" ng-model="myProfile.password_confirmation" class="form-control">
                                <span style="color:red;">{{errors.password_confirmation[0]}}</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Vai trò<span style="color:red">*</span></label>
                                <input ng-model="myProfile.user_role" disabled class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Địa chỉ website</label>
                                <input ng-model="myProfile.enterprise_website" class="form-control">
                                <span style="color:red;">{{errors.enterprise_website[0]}}</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Loại hình<span style="color:red">*</span></label>
                                <select ng-model="myProfile.type_id" class="form-control">
                                    <option value="">-- Chọn loại hình --</option>
                                    <option ng-repeat="item in data.listType" ng-value="item.id">{{item.name}}</option>
                                </select>
                                <span style="color:red;">{{errors.type_id[0]}}</span>
                            </div>
                            <div class="col-md-6">
                                <label>Lĩnh vực<span style="color:red">*</span></label>
                                <select ng-model="myProfile.spec_id" class="form-control">
                                    <option value="">-- Chọn lĩnh vực --</option>
                                    <option ng-repeat="item in data.listSpec" ng-value="item.id">{{item.name}}</option>
                                </select>
                                <span style="color:red;">{{errors.spec_id[0]}}</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Số điện thoại</label>
                                <input ng-model="myProfile.user_phone" class="form-control">
                                <span style="color:red;">{{errors.user_phone[0]}}</span>
                            </div>
                            <div class="col-md-6">
                                <label>Ảnh đại diện</label>
                                <button id="button_avatar" style="margin-left:10px;" class="btn btn-default btn-sm">
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                    &ensp;Tải ảnh lên</button>
                                <input id="input_avatar" style="display: none" type="file" class="form-control" accept=".png,.jpeg,.jpg">
                                <div>
                                    <img id="show_avatar" style="margin-top:5px;" width="200px;" ng-src="{{myProfile.user_avatar}}" />
                                    <span id="remove_avatar" style="color:red;cursor:pointer;font-size:18px;"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Họ tên (Cá nhân)<span style="color:red">*</span></label>
                                <input ng-model="myProfile.user_name" class="form-control">
                                <span style="color:red;">{{errors.user_name[0]}}</span>
                            </div>
                            <div class="col-md-6">
                                <label>Chức vụ</label>
                                <input ng-model="myProfile.job" class="form-control">
                                <span style="color:red;">{{errors.job[0]}}</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Tỉnh/Thành phố<span style="color:red">*</span></label>
                                <select ng-change="actions.changeDistrict()" ng-model="myProfile.province_id" class="form-control">
                                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                    <option ng-repeat="item in data.listProvince" ng-value="item.id">{{item.name}}</option>
                                </select>
                                <span style="color:red;">{{errors.province_id[0]}}</span>
                            </div>
                            <div class="col-md-4">
                                <label>Quận/Huyện<span style="color:red">*</span></label>
                                <select ng-change="actions.changeVillage()" ng-model="myProfile.district_id" class="form-control">
                                    <option value="">-- Chọn Quận/Huyện --</option>
                                    <option ng-repeat="item in data.listDistrict" ng-value="item.id">{{item.name}}</option>
                                </select>
                                <span style="color:red;">{{errors.district_id[0]}}</span>
                            </div>
                            <div class="col-md-4">
                                <label>Phường/Xã<span style="color:red">*</span></label>
                                <select class="form-control" ng-model="myProfile.village_id">
                                    <option value="">-- Chọn Phường/Xã --</option>
                                    <option ng-repeat="item in data.listVillage" ng-value="item.id">{{item.name}}</option>
                                </select>
                                <span style="color:red;">{{errors.village_id[0]}}</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-8">
                                <label>Địa chỉ cụ thể</label>
                                <input ng-model="myProfile.address" class="form-control"></input>
                                <span style="color:red;">{{errors.address[0]}}</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="actions.changeProfile()">Cập nhật
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-close"></i> Hủy
                    </button>
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
                            <col width="50px">
                            </col>
                            <col width="150px">
                            </col>
                            <col width="50%">
                            </col>
                            <col width="30%">
                            </col>
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
                                <a class="display-block print-hide" ng-repeat-start="file in data.active_notify.files" href="{{actions.getPath(file.filepath)}}" target="_blank">- {{file.filename}}
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


</div>
