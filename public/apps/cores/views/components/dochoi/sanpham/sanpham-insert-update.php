<div ng-show="!data.showList && !data.showDetail" class="box box-primary">
    <div class="card margin-bottom0">
        <div class="card-body padding-bottom0 padding0">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-title">
                        <div ng-if="data.statusInsert" class="box-title-text">Thêm mới </div>
                        <div ng-if="!data.statusInsert" class="box-title-text">Cập nhật </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body my_box card tab-content mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tên sản phẩm:</label>
                        <input ng-model="data.singleData.name" class="form-control" placeholder="Nhập tên..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Mã sản phẩm:</label>
                        <input ng-model="data.singleData.code" class="form-control" placeholder="Nhập mã..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Loại sản phẩm:</label>
                        <select class="form-control" ng-model="data.singleData.dochoi_loai_san_pham_id"
                            ng-change="actions.changeLoaisanpham()">
                            <option value="">-- Chọn loại sản phẩm --</option>
                            <option ng-value="item.id" ng-repeat="item in data.listLoaisanpham">{{item.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Danh mục:</label>
                        <input type="text" class="form-control" ng-value='data.danhmuc_name' disabled>
                    </div>
                </div>

                <div class="col-md-12 mt-2">
                    <table class="table table-bordered table-striped">
                        <thead class="table-green">
                            <tr>
                                <th class="text-center align-middle">Màu</th>
                                <th class="text-center align-middle">Size</th>
                                <th class="text-center align-middle">Số lượng</th>
                                <th class="text-center align-middle">Ảnh sản phẩm</th>
                                <th class="text-center align-middle">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="info in data.singleData.info_product">
                                <td class="text-center">
                                    <select name="" id="" ng-model="info.size_id" class="form-control">
                                        <option value="">Chọn size</option>
                                        <option ng-repeat="item in data.listSize" ng-value="item.id">{{item.name}}
                                        </option>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <select name="" id="" class="form-control" ng-model="info.color_id">
                                        <option value="">Chọn màu</option>
                                        <option ng-repeat="item in data.listColor" ng-value="item.id">{{item.name}}
                                        </option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <input type="number" ng-model="info.quantity" class="form-control"
                                        placeholder="Nhập số lượng">
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <button class="btn btn-outline-danger tooltip-css"
                                        ng-click="actions.removeInfo($index)">
                                        <i class="bx bxs-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <button class="btn btn-sm btn-primary ng-scope" ng-click="actions.addInfo()"><i
                                            class="bx bx-list-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Giá sản phẩm:</label>
                            <input type='number' ng-model="data.singleData.price" class="form-control"
                                placeholder="Nhập giá..." />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Đánh giá:</label>
                            <input type='number' ng-model="data.singleData.quantity" class="form-control"
                                placeholder="Nhập đánh giá..." />
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Mô tả:</label>
                            <textarea rows="4" name="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label>Chi tiết:</label>
                            <textarea rows="12" name="content_detail" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <b>Ảnh đính kèm:<span style="color: #d81b1b">*</span></b>
                        <button id="button_upload_images" class="btn btn-sm btn-light">
                            <i class="fa fa-upload" aria-hidden="true"></i> Tải ảnh lên
                        </button>
                        <input id="input_upload_images" style="display: none" type="file" accept=".png,.jpeg,.jpg"
                            multiple="multiple">
                        <div>
                            <span ng-repeat="media in data.singleData.medias"
                                style="display: inline-block;position: relative">
                                <img ng-src="{{media.filepath}}" style="margin:5px;" height="90px">
                                <i class="fa fa-times-circle text-danger" ng-click="actions.deleteImageUpdate($index)"
                                    style="font-size:18px;cursor:pointer;position: absolute;top: 0;right: -4px;"
                                    title="Xóa ảnh"></i>
                            </span>
                        </div>
                        <div id="preview_images"></div>
                        <span style="color:red;">{{errors.listMediaId[0]}}</span>
                    </div>
                </div>
            </div>
            <div class="button-section text-center" style="margin:25px;">
                <button ng-if="data.statusInsert" ng-click="actions.insert()" class="btn btn-primary">
                    <i class="bx bx-save"></i> Thêm mới
                </button>
                <button ng-if="!data.statusInsert" ng-click="actions.update(data.singleData.id)"
                    class="btn btn-primary">
                    <i class="bx bx-save"></i> Cập nhật</button>
                <button class="btn btn-light" ng-click="actions.handleShowList(true)">
                    <i class="bx bx-left-arrow-alt"></i> Quay lại</button>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>