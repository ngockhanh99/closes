<div ng-if="data.showDetail"  class="box box-primary">
    <div class="card margin-bottom0">
        <div class="card-body padding-bottom0 padding0">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-title">
                        <div class="box-title-text">Chi tiết tin bài</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.box-header -->
    <div class="box-body my_box tab-content mt-3">
        <div class="content-section" style="margin:0px 50px;">
            <table class="table table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="*">
                </colgroup>
                <tbody>
                    <tr>
                        <th>Tiêu đề</th>
                        <td>{{data.singleArticle.title}}</td>
                    </tr>
                    <tr>
                        <th>Thuộc chuyên mục</th>
                        <td>{{data.singleArticle.category.name}}</td>
                    </tr>
                    <tr>
                        <th>Người viết</th>
                        <td>{{data.singleArticle.user.user_name}}</td>
                    </tr>
                    <tr>
                        <th>Là tin nổi bật</th>
                        <td><i ng-class="item.is_hightlight?'fa fa-check text-success':'fa fa-times-circle-o text-danger'" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>{{data.singleArticle.status == 1?'Hiển thị':'Không hiển thị'}}</td>
                    </tr>
                    <tr>
                        <th>Thứ tự</th>
                        <td>{{data.singleArticle.order}}</td>
                    </tr>
                    <tr>
                        <th>Mô tả</th>
                        <td>{{data.singleArticle.description}}</td>
                    </tr>
                    <tr>
                        <th>Nội dung</th>
                        <td ng-bind-html="trustedContent"></td>
                    </tr>
                    <tr>
                        <th>Nội dung trên mobile</th>
                        <td>{{data.singleArticle.content_mobile}}</td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{data.singleArticle.created_at | formatDateTime}}</td>
                    </tr>
                    <tr>
                        <th>Ngày cập nhật</th>
                        <td>{{data.singleArticle.updated_at | formatDateTime}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="button-section text-center" style="margin:25px;">
            <button ng-click="actions.showDetail(false)" class="btn btn-light">
                <i class="bx bx-left-arrow-alt"></i> Quay lại
            </button>
        </div>
    </div>
    <!-- /.box-body -->
</div>
