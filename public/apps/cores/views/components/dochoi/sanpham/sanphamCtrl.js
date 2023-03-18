angular.module('myApp', []).controller('sanphamCtrl', function ($scope, $http, $sce, $rootScope, $apply) {
    $scope.data = {
        listData: {},
        singleData: {},
        listLoaisanpham: {},
        listDanhmuc: {},
        statusInsert: true,
        showList: true,
        showDetail: false,
        uploadImage: new UploadFile('input_upload_images', 'button_upload_images', 'preview_images'),
    }
    $scope.search = {
        per_page: '20',
        total: 1,
        page: 1,
    }
    $scope.errors = {}
    $scope.actions = {
        initial() {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: SITE_ROOT + 'rest/media/upload-ckeditor',
                filebrowserImageUploadUrl: SITE_ROOT + 'rest/media/upload-ckeditor?type=Images',
                fileTools_requestHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('description')
                }
            });
            CKEDITOR.replace('content_detail', {
                filebrowserUploadUrl: SITE_ROOT + 'rest/media/upload-ckeditor',
                filebrowserImageUploadUrl: SITE_ROOT + 'rest/media/upload-ckeditor?type=Images',
                fileTools_requestHeaders: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content_detail')
                }
            });
            $scope.actions.uploadImages();
            $scope.actions.getAll()
            $scope.actions.getSize()
            $scope.actions.getColor()
            $scope.actions.getLoaisanpham()
        },
        getAll() {
            $rootScope.reloadPage = true
            $http.get(SITE_ROOT + 'dochoi/sanpham', { params: $scope.search })
                .then(response => {
                    $scope.search.total = response.data.total
                    $scope.data.listData = response.data.data
                })
                .catch(() => $.notify('Lấy danh sách thất bại!', 'error'))
                .finally(() => $rootScope.reloadPage = false)
        },
        getLoaisanpham() {
            $http.get(SITE_ROOT + 'dochoi/loaisanpham')
                .then(response => {
                    $scope.data.listLoaisanpham = response.data
                })
        },
        getSize() {
            $http.get(SITE_ROOT + 'dochoi/size')
                .then(response => {
                    $scope.data.listSize = response.data
                })
        },
        getColor() {
            $http.get(SITE_ROOT + 'dochoi/mau')
                .then(response => {
                    $scope.data.listColor = response.data
                })
        },
        changeLoaisanpham() {
            if ($scope.data.singleData.dochoi_loai_san_pham_id == "") {
                $scope.data.danhmuc_name = ""
                return
            }
            let loaisanpham = $scope.data.listLoaisanpham.find(item => item.id == $scope.data.singleData.dochoi_loai_san_pham_id);
            if (typeof loaisanpham.danhmuc != "undefined") {
                $scope.data.danhmuc_name = loaisanpham.danhmuc.name
            }
        },
        insert() {
            $rootScope.reloadPage = true;
            $scope.data.singleData.description = CKEDITOR.instances.description.getData()
            $scope.data.singleData.description_detail = CKEDITOR.instances.content_detail.getData()
            $http.post(SITE_ROOT + 'dochoi/sanpham/insert', $scope.data.singleData)
                .then(() => {
                    $scope.actions.getAll()
                    $scope.data.showList = true
                    $.notify('Thêm mới thành công!', 'success')
                })
                .catch(errors => {
                    $scope.errors = errors.data.errors
                    $.notify('Thêm mới thất bại!', 'error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        update(id) {
            $rootScope.reloadPage = true
            $scope.data.singleData.description = CKEDITOR.instances.description.getData()
            $scope.data.singleData.description_detail = CKEDITOR.instances.content_detail.getData()
            $http.put(SITE_ROOT + 'dochoi/sanpham/update/' + id, $scope.data.singleData)
                .then(() => {
                    $scope.actions.getAll()
                    $scope.data.showList = true
                    $.notify('Cập nhật thành công!', 'success')
                })
                .catch(errors => {
                    $scope.errors = errors.data.errors
                    $.notify('Cập nhật thất bại!', 'error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        delete(id) {
            let check = confirm('Bạn có muốn xóa đối tượng đã chọn!')
            if (!check) return
            $http.delete(SITE_ROOT + 'dochoi/sanpham//delete/' + id)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Xóa thành công!', 'success')
                })
                .catch(() => $.notify('Xóa thất bại!', 'error'))
        },
        deleteImageUpdate(index) {
            $scope.data.singleData.medias.splice(index, 1)
        },
        handleShowList(status, isInsert, index) {
            $scope.errors = {}
            $scope.data.showList = status
            $scope.data.statusInsert = isInsert
            $scope.data.singleData = { ...$scope.data.listData[index] }
            if (isInsert) {
                $scope.data.singleData.medias = []
                $scope.data.danhmuc_name = ""
                $scope.data.singleData.info_product = [{
                    size_id: "",
                    color_id: "",
                    media_id: "",
                    quantity: 0
                }]
            } else {
                if (typeof $scope.data.singleData.loaisanpham != "undefined") {
                    $scope.data.danhmuc_name = $scope.data.singleData.loaisanpham.danhmuc.name
                }
            }
            CKEDITOR.instances.description.setData($scope.data.singleData.description)
            CKEDITOR.instances.content_detail.setData($scope.data.singleData.description_detail)
        },
        changePerPage() {
            $scope.search.page = 1
            $scope.actions.getAll()
        },
        addInfo() {
            $scope.data.singleData.info_product.push({
                size_id: "",
                color_id: "",
                media_id: "",
                quantity: 0
            })
        },
        removeInfo(index) {
            $scope.data.singleData.info_product.splice(index, 1)
        },
        getPathImg(filepath) {
            if (!filepath) {
                return SITE_ROOT + 'apps/cores/images/default_image.png';
            }
            return filepath;
        },
        gotoPage(page) {
            console.log(page);
            window.scrollTo(0, 0);
            $scope.search.page = page;
            $scope.actions.getAll();
        },
        search() {
            $scope.actions.getAll()
        },
        uploadImages() {
            $scope.data.uploadImage.getInput().onchange = function () {
                $scope.data.uploadImage.doUpload()
                    .then(res => {
                        $apply(function () {
                            console.log($scope.data.singleData.medias);
                            $scope.data.singleData.medias = $scope.data.singleData.medias.concat(res)
                        })
                    })
            }
        },
    }
    $scope.actions.initial()
})
