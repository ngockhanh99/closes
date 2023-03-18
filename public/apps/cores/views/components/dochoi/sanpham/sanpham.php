<div class="card margin-bottom0" ng-if="data.showList && !data.showDetail">
    <div class="card-body padding-bottom0 padding0">
        <div class="row">
            <div class="col-md-12">
                <div class="box-title">
                    <div class="box-title-text"><span>Danh sách tin bài</span></div>
                    <div class="box-title-layout">
                        <div class="flex">
                            <input type="text" class="form-control form-filter" ng-model="search.key_word"
                                ng-enter="actions.search()" placeholder="Tìm kiếm ...">
                        </div>
                        <div class="flex text-right" style="margin-left: auto; max-width: 40px; height: 37px;">
                            <button type="button" class="btn" ng-click="actions.search()">
                                <i aria-hidden="true" class="fas fa fa-search "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3" ng-if="data.showList && !data.showDetail">
    <div class="card-body pt-1">
        <div class="row">
            <div class="col-md-12 mb-1">
                <button class="btn btn-primary" ng-click="actions.handleShowList(false,true);">
                    <i class="bx bx-plus-medical"></i> Thêm mới
                </button>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="article_table">
                    <colgroup>
                        <col width="50px" />
                        <col width="*" />
                        <col width="12%" />
                        <col width="180px" />
                        <col width="15%" />
                        <col width="12%" />
                        <col width="8%" />
                        <col width="8%" />
                        <col width="8%" />
                    </colgroup>
                    <thead class="table-green">
                        <tr>
                            <th class="text-center align-middle">STT</th>
                            <th class="text-center align-middle">Tên sản phẩm</th>
                            <th class="text-center align-middle">Mã sản phẩm</th>
                            <th class="text-center align-middle">Hình ảnh</th>
                            <th class="text-center align-middle">Loại sản phẩm</th>
                            <th class="text-center align-middle">Danh mục</th>
                            <th class="text-center align-middle">Đơn giá</th>
                            <th class="text-center align-middle">Số lượng</th>
                            <th class="text-center align-middle">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in data.listData" style="height: 100px;">
                            <td class="text-center align-top">
                                {{$index + (search.page - 1) * search.per_page + 1}}
                            </td>
                            <td class="align-top">{{item.name}}</td>
                            <td class="align-top">{{item.code}}</td>
                            <td class="align-middle text-center">
                                <img ng-src="{{actions.getPathImg(item.medias[0].filepath)}}"
                                    style="border:1px solid lightgrey;object-fit: cover;" height="100px" width="150px">
                            </td>
                            <td class="align-top">{{item.loaisanpham.name}}</td>
                            <td class="align-top">{{item.loaisanpham.danhmuc.name}}</td>
                            <td class="align-top">{{item.price}}</td>
                            <td class="align-top">{{item.quantity}}</td>
                            <td class="text-center align-top">
                                <button type="button" class="btn btn-primary tooltip-css"
                                    ng-click="actions.handleShowList(false,false,$index)">
                                    <i class="bx bx-edit" aria-hidden="true"></i>
                                    <span class="tooltiptext">Sửa</span>
                                </button>
                                <button type="button" class="btn btn-danger tooltip-css"
                                    ng-click="actions.delete(item.id)" ng-if="!item.status">
                                    <i class="bx bx-trash" aria-hidden="true"></i>
                                    <span class="tooltiptext">Xóa</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <paginate-dir page="search.page" page-size="search.per_page" total="search.total"
            paging-action="actions.gotoPage(search.page)">
        </paginate-dir>
    </div>
</div>
</div>
<!--    Thêm mới, update-->
<?php include 'sanpham-insert-update.php' ?>
<!--    Chi tiêt Article-->
<?php include 'sanpham-detail.php' ?>