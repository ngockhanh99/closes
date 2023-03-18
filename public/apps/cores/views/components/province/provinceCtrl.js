var myApp = angular.module('myApp', [])
myApp.controller('provinceCtrl', function ($scope, $http, $apply) {
    $scope.data = {
        listProvince: {},
        singleProvince: [],
        statusInsert: true,
    }
    $scope.search = {
        keyword: '',
        limit: '20',
        page: 1,
        total: 1,
    }
    $scope.errors = {}
    $scope.actions = {
        initial() {
            $scope.actions.getAll()
        },
        getAll() {
            $http.get(SITE_ROOT + 'rest/province', {params: $scope.search})
                .then(response => {
                    $scope.search.total = response.data.total
                    $scope.data.listProvince = response.data.data;
                }, () => {
                    $.notify('Lấy danh sách thất bại!', 'error')
                })
        },
        insertProvince() {
            $http.post(SITE_ROOT + 'rest/province/insert', $scope.data.singleProvince)
                .then(() => {
                    $scope.actions.getAll()
                    $('#modal_single').modal('hide')
                    $.notify('Thêm mới thành công!', 'success')
                }, errors => {
                    $scope.errors = errors.data.errors
                    $.notify('Thêm mới thất bại!', 'error')
                })
        },
        updateProvince(id) {
            $http.put(SITE_ROOT + 'rest/province/update/' + id, $scope.data.singleProvince)
                .then(() => {
                    $scope.actions.getAll()
                    $('#modal_single').modal('hide')
                    $.notify('Thêm mới thành công!', 'success')
                }, errors => {
                    $scope.errors = errors.data.errors
                    $.notify('Thêm mới thất bại!', 'error')
                })
        },
        deleteProvince(id) {
            let checkDelete = confirm('Bạn có muốn xóa đối tượng đã chọn?')
            if (!checkDelete) return

            $http.delete(SITE_ROOT + 'rest/province/delete/' + id)
                .then(() => {
                    $scope.actions.getAll()
                    $.notify('Xóa thành công!', 'success')
                }, () => {
                    $.notify('Xóa thất bại!', 'error')
                })

        },
        showModalProvince(status, index) {
            $scope.errors = {}
            $scope.data.statusInsert = status
            $scope.data.singleProvince = {...$scope.data.listProvince[index]}
            if(status) $scope.data.singleProvince.status = 1
            $('#modal_single').modal('show')
        },
        changePerPage(){
            $scope.search.page = 1
            $scope.actions.getAll()
            document.getElementById('province_table').scrollIntoView()
        },
        search() {
            $scope.search.page = 1;
            $scope.actions.getAll();
        },
        gotoPage(page) {
            window.scrollTo(0, 0);
            $scope.search.page = page;
            $scope.actions.getAll();
        },
    }
    $scope.actions.initial()
})