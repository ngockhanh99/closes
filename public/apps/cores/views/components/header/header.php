<div ng-controller="headerCtrl">
    <header id="page-topbar">
        <div class="navbar-header height-header" id="trong-dong">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">

                </div>

                <button type="button" class="btn btn-sm px-3 icon-f font-size-16 header-item waves-effect"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- App Search-->
                <div class="position-relative right-50 backgr-bannner">
                    <div class="logo-section">
                        <div class="navbar-left text-uppercase text-center div-header">
                            <div class="text-header">
                                <b class="full-name-header">Quản lý</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex">

                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect "
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="mdi mdi-magnify icon-f"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">

                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..."
                                        aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect " data-toggle="fullscreen">
                        <i class="bx bx-fullscreen icon-f"></i>
                    </button>
                </div>
                <div class="dropdown d-inline-block">

                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img ng-if="!userInfo.user_avatar" class="rounded-circle header-profile-user"
                            src="<?php echo url('apps/cores/images') ?>/avata-default.jpg" alt="Header Avatar">
                        <img ng-if="userInfo.user_avatar" ng-src="{{userInfo.user_avatar}}"
                            class="rounded-circle header-profile-user" alt="User Image">

                        <span class="d-none d-xl-inline-block ms-1 icon-f" key="t-henry">{{userInfo.user_name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block icon-f"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="javascript:;" ng-if="userInfo.user_email">
                            <i class="bx bx-envelope font-size-16 align-middle me-1"></i>
                            <span key="t-profile">{{userInfo.user_email}}</span>
                        </a>
                        <a class="dropdown-item" href="javascript:;" ng-click="actions.showModalAccountInfo()">
                            <i class="bx bx-user-circle font-size-16 align-middle me-1"></i>
                            <span key="t-profile">Thông tin tài khoản</span>
                        </a>
                        <a class="dropdown-item" href="javascript:;" ng-click="actions.backup()"
                            ng-if="rootOptions.CHANGE_PASSWORD">
                            <i class="bx bx-sync font-size-16 align-middle me-1"></i>
                            <span key="t-profile">Backup dữ liệu</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="javascript:;" ng-click="actions.logout()">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                            <span key="t-logout">
                                Đăng xuất
                            </span>
                        </a>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="bx bx-cog bx-spin icon-f"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- Modal cập nhật thông tin tài khoản -->
    <div class="modal fade" id="update_account_info" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header style-changePass">
                    <h4 class="modal-title ">Cập nhật thông tin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="change-profile row">
                        <div class="col-md-6">
                            <label>Tên Doanh nghiệp/Tổ chức<span style="color:red">*</span></label>
                            <input ng-model="myProfile.user_name" class="form-control"
                                placeholder="Nhập tên Doanh nghiệp/Tổ chức...">
                            <span style="color:red;">{{errors.user_name[0]}}</span>
                        </div>
                        <div class="col-md-6">
                            <label>Email (Tên đăng nhập)</label>
                            <input ng-value="myProfile.user_email" disabled class="form-control">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Mật khẩu mới</label>
                            <input type="password" ng-model="myProfile.password" class="form-control"
                                placeholder="Nhập mật khẩu...">
                            <span style="color:red;">{{errors.password[0]}}</span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Nhập lại mật khẩu</label>
                            <input type="password" ng-model="myProfile.password_confirmation" class="form-control"
                                placeholder="Xác nhận mật khẩu...">
                            <span style="color:red;">{{errors.password_confirmation[0]}}</span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Vai trò</label>
                            <input ng-value="myProfile.user_role" disabled class="form-control">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Địa chỉ website</label>
                            <input ng-model="myProfile.enterprise_website" class="form-control"
                                placeholder="Nhập địa chỉ website...">
                            <span style="color:red;">{{errors.enterprise_website[0]}}</span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Loại hình<span style="color:red">*</span></label>
                            <select ng-model="myProfile.type_id" class="form-control">
                                <option value="">-- Chọn loại hình --</option>
                                <option ng-repeat="item in data.listType" ng-value="item.id">{{item.name}}</option>
                            </select>
                            <span style="color:red;">{{errors.type_id[0]}}</span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Lĩnh vực<span style="color:red">*</span></label>
                            <select disabled ng-model="myProfile.spec_id" class="form-control">
                                <option value="">-- Chọn lĩnh vực --</option>
                                <option ng-repeat="item in data.listSpec" ng-value="item.id">{{item.name}}</option>
                            </select>
                            <span style="color:red;">{{errors.spec_id[0]}}</span>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Số điện thoại</label>
                            <input disabled ng-value="myProfile.user_phone" class="form-control"
                                placeholder="Nhập số điện thoại...">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Ảnh đại diện: </label>
                            <button id="button_avatar" style="margin-left:10px;" class="btn btn-light btn-sm">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                                &ensp;Tải ảnh lên</button>
                            <input id="input_avatar" style="display: none" type="file" class="form-control"
                                accept=".png,.jpeg,.jpg">
                            <div>
                                <img id="show_avatar" style="margin-top:5px;" width="150px;"
                                    ng-src="{{myProfile.user_avatar}}" />
                                <span id="remove_avatar" style="color:red;cursor:pointer;font-size:18px;"><i
                                        class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Họ tên (Cá nhân)</label>
                            <input ng-model="myProfile.personal_name" class="form-control"
                                placeholder="Nhập họ tên cá nhân...">
                            <span style="color:red;">{{errors.personal_name[0]}}</span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Chức vụ</label>
                            <input ng-model="myProfile.job" class="form-control" placeholder="Nhập chức vụ...">
                            <span style="color:red;">{{errors.job[0]}}</span>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Tỉnh/Thành phố<span style="color:red">*</span></label>
                            <select ng-change="actions.changeDistrict()" ng-model="myProfile.province_id"
                                class="form-control">
                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                <option ng-repeat="item in data.listProvince" ng-value="item.id">{{item.name}}</option>
                            </select>
                            <span style="color:red;">{{errors.province_id[0]}}</span>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label>Quận/Huyện<span style="color:red">*</span></label>
                            <select ng-change="actions.changeVillage()" ng-model="myProfile.district_id"
                                class="form-control">
                                <option value="">-- Chọn Quận/Huyện --</option>
                                <option ng-repeat="item in data.listDistrict" ng-value="item.id">{{item.name}}</option>
                            </select>
                            <span style="color:red;">{{errors.district_id[0]}}</span>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label>Phường/Xã<span style="color:red">*</span></label>
                            <select class="form-control" ng-model="myProfile.village_id">
                                <option value="">-- Chọn Phường/Xã --</option>
                                <option ng-repeat="item in data.listVillage" ng-value="item.id">{{item.name}}</option>
                            </select>
                            <span style="color:red;">{{errors.village_id[0]}}</span>
                        </div>

                        <div class="col-md-8 mt-3">
                            <label>Địa chỉ cụ thể<span style="color:red">*</span></label>
                            <input ng-model="myProfile.address" class="form-control"
                                placeholder="Nhập địa chỉ cụ thể..." />
                            <span style="color:red;">{{errors.address[0]}}</span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" ng-click="actions.changeProfile()">
                        <i class="bx bx-save"></i> Cập nhật
                    </button>
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">
                        <i class="bx bx-x-circle"></i> Hủy
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
                    <h4 class="modal-title ">Thông báo</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
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
                        <tr class="table-info">
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
                                    href="{{actions.getPath(file.filepath)}}" target="_blank">- {{file.filename}}
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