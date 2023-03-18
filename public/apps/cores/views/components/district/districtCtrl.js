var myApp = angular.module('myApp',[])
myApp.controller('districtCtrl', function($scope,$http,$apply){
    $scope.data = {
        listDistrict: {},
        listProvince: {},
        singleDistrict: {},
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
            $scope.actions.getProvince()
        },
        getAll() {
            $http.get(SITE_ROOT + 'rest/district',{params:$scope.search})
            .then(response => {
                $scope.search.total = response.data.total
                $scope.data.listDistrict = response.data.data;
            },() => {
                $.notify('Lấy danh sách thất bại!', 'error')
            })
        },
        getProvince(){
            $http.get(SITE_ROOT + 'rest/province')
            .then(response => {
                $scope.data.listProvince = response.data;
            },() => {
                $.notify('Lấy danh sách Tỉnh/Thành phố!', 'error')
            })
        },
        insertDistrict(){
            $http.post(SITE_ROOT + 'rest/district/insert',$scope.data.singleDistrict)
            .then( () => {
                $scope.actions.getAll()
                $('#modal_single').modal('hide')
                $.notify('Thêm mới thành công!', 'success')
            },errors => {
                $scope.errors = errors.data.errors
                $.notify('Thêm mới thất bại!', 'error')
            })
        },
        updateDistrict(id){
            $http.put(SITE_ROOT + 'rest/district/update/'+id,$scope.data.singleDistrict)
            .then( () => {
                $scope.actions.getAll()
                $('#modal_single').modal('hide')
                $.notify('Thêm mới thành công!', 'success')
            },errors => {
                $scope.errors = errors.data.errors
                $.notify('Thêm mới thất bại!', 'error')
            })
        },
        deleteDistrict(id) {
            let checkDelete = confirm('Bạn có muốn xóa đối tượng đã chọn?')
            if(!checkDelete) return

            $http.delete(SITE_ROOT + 'rest/district/delete/'+id)
            .then( () => {
                $scope.actions.getAll()
                $.notify('Xóa thành công!', 'success')
            },() => {
                $.notify('Xóa thất bại!', 'error')
            })

        },
        showModalDistrict(status,index) {
            $scope.errors = {}
            $scope.data.statusInsert = status
            $scope.data.singleDistrict = {...$scope.data.listDistrict[index]}
            if(status) $scope.data.singleDistrict.status = 1
            $('#modal_single').modal('show')
        },
        search(){
            $scope.search.page = 1;
            $scope.actions.getAll();
        },
        changePerPage(){
            $scope.search.page = 1
            $scope.actions.getAll()
            document.getElementById('district_table').scrollIntoView()
        },
        gotoPage(page) {
            window.scrollTo(0, 0);
            $scope.search.page = page;  
            $scope.actions.getAll();
        },
    }
    $scope.actions.initial()
})