var myApp = angular.module('myApp')

myApp.controller('donhangCtrl', function ($scope, $http, $rootScope) {
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
        },
        getAll() {
            $rootScope.reloadPage = true
            $http.get(SITE_ROOT + 'dochoi/donhang', { params: $scope.search })
                .then(response => {
                    $scope.search.total = response.total
                    $scope.data.listData = response.data
                })
                .catch(() => $.notify('Lấy danh sách thất bại!', 'error'))
                .finally(() => $rootScope.reloadPage = false)
        },
        insert() {
            $rootScope.reloadPage = true
            $http.post(SITE_ROOT + 'dochoi/mau/insert', $scope.data.singleData)
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
            $http.put(SITE_ROOT + 'dochoi/mau/update/' + id, $scope.data.singleData)
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
            $http.delete(SITE_ROOT + 'dochoi/mau/delete/' + id)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Xóa thành công!', 'success')
                })
                .catch(error => {
                    $.notify('Xóa thất bại!', 'error')
                })
        },
        getPathImg(filepath) {
            if (!filepath) {
                return SITE_ROOT + 'apps/cores/images/default_image.png';
            }
            return filepath;
        },
        showModalDetail(order_detail){
            console.log(order_detail)
            $scope.data.order_detail = order_detail
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
    $scope.actions.initial()
})