var myApp = angular.module('myApp')

myApp.controller('danhmucCtrl', function ($scope, $http, $rootScope) {
    $scope.data = {
        listData: {},
        singleData: {},
        isInsert: true,
    }
    $scope.search = {
        key_word: '',
        per_page: '20',
        page: 1,
        total: 1,
    }
    $scope.errors = {}

    $scope.actions = {
        initial() {
            $scope.actions.getAll()
            fileUpload("button_upload", "input_upload");
        },
        getAll() {
            $rootScope.reloadPage = true
            $http.get(SITE_ROOT + 'dochoi/danhmuc', { params: $scope.search })
                .then(response => {
                    $scope.search.total = response.data.total
                    $scope.data.listData = response.data.data
                })
                .catch(() => $.notify('Lấy danh sách thất bại!', 'error'))
                .finally(() => $rootScope.reloadPage = false)
        },
        insert() {
            $rootScope.reloadPage = true
            $http.post(SITE_ROOT + 'dochoi/danhmuc/insert', $scope.data.singleData)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Thêm mới thành công!', 'success')
                    $('#modal_single').modal('hide')
                })
                .catch(error => {
                    $scope.errors = error.data.errors
                    $.notify('Thêm mới thất bại!', 'error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        update(id) {
            $rootScope.reloadPage = true
            $http.put(SITE_ROOT + 'dochoi/danhmuc/update/' + id, $scope.data.singleData)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Cập nhật thành công!', 'success')
                    $('#modal_single').modal('hide')
                })
                .catch(error => {
                    $scope.errors = error.data.errors
                    $.notify('Cập nhật thất bại!', 'error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        delete(id) {
            let check = confirm('Bạn có muốn xóa đối tượng đã chọn?')
            if (!check) return
            $http.delete(SITE_ROOT + 'dochoi/danhmuc/delete/' + id)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Xóa thành công!', 'success')
                })
                .catch(error => {
                    $.notify('Xóa thất bại!', 'error')
                })
        },
        showModal(status, index) {
            showListImage('', "show_list_images");
            $scope.errors = {}
            $scope.data.isInsert = status
            $scope.data.singleData = { ...$scope.data.listData[index] }
            if (status) $scope.data.singleData.status = 1
            if ($scope.data.singleData.media) showListImage($scope.data.singleData.media, "show_list_images");
            $('#modal_single').modal('show')
        },
        search() {
            $scope.actions.getAll()
        },
        changePerPage() {
            $scope.search.page = 1
            $scope.actions.getAll()
        },
        gotoPage(page) {
            window.scrollTo(0, 0)
            $scope.search.page = page
            $scope.actions.getAll()
        },

    }
    function fileUpload(button_upload, input_upload) {
        const button = document.getElementById(button_upload);
        const input = document.getElementById(input_upload);

        button.onclick = () => input.click();

        input.onchange = () => {
            let formData = new FormData();
            for (let item of input.files) {
                formData.append("files[]", item);
            }
            doUpload(formData).then((result) => {
                $scope.data.singleData.media_id = result[0].id;
                showListImage(result[0], "show_list_images");
            });
        };
    }

    function doUpload(formData) {
        let token = document
            .querySelector("meta[name=csrf-token]")
            .getAttribute("content");
        return fetch(SITE_ROOT + "rest/media/upload-file", {
            method: "post",
            headers: {
                "X-CSRF-Token": token,
            },
            body: formData,
        }).then((response) => response.json());
    }

    function showListImage(result, idElement = "") {
        const showListImage = document.getElementById(idElement);
        if (typeof result == 'string') {
            showListImage.innerHTML = "";
            return
        }
        if (!showListImage) return;
        if (typeof result != 'undefined') {
            html = `<div class="style-img">
            <image alt="${result.filename}" src="${result.filepath}" />
            </div>`
        } else {
            html = ''
        }
        showListImage.innerHTML = html;
    }

    $scope.actions.initial()
})