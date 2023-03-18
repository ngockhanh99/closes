angular.module('myApp').controller("listUserCtrl", function ($scope, $location,
                                                             $http, $apply, $stateParams,
                                                             $ouServices, $userServices, $groupServices) {

    $scope.data = {
        listPermit: [], //Danh sách quyền
        allUsers: [], //Danh sach NSD
        allOu: [],//Danh danh don vi ben menu trai
        dataSearch: {
            page: 1,
            page_size: 30,
            ou_id: '',
            total: 0,
            permit: '',
            keywords: ''
        },
    };

    $scope.errors = {
        user: {}
    };
    /**
     * 1. Load all users
     * 2. The moi use
     * 2.1 Hien thi danh sach nhom
     * 2.1.1 Chon nhóm
     * 2.1.2 Bo chon nhom
     * 3.1 Hien thi danh sach don vi
     * 3.1.1 Chon don vi
     * 3.1.2 Bo chon don vi
     */
    $scope.actions = {
        initial: function () {
            //all user
            $scope.actions.loadAllPermit();
            $scope.actions.allUser();
        },
        allUser: function () {
            $userServices.getAll($scope.data.dataSearch)
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.allUsers = resp.data.data;
                        $scope.data.dataSearch.total = resp.data.total;
                    });
                }, function (error) {
                    $.notify('Lấy danh sách đơn vị, phòng ban thất bại', 'error');
                });
        },
        changePage: function(page){
            $scope.data.dataSearch.page = page;
            $scope.actions.allUser();
        },
        /**
         * Lấy danh sách quyền
         * @returns {Promise}
         */
        loadAllPermit: function () {
            $http.get(SITE_ROOT + 'rest/permit').then(
                function (resp) {
                    $scope.data.listPermit = resp.data;
                    resolve();
                },
                function (error) {
                    $.notify('Lấy danh sách quyền thất bại', 'error');
                    reject();
                });

        },
    };
    $scope.actions.initial();
});



