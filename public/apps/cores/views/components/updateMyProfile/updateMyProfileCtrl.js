angular.module('myApp').controller("updateMyProfileCtrl", function ($scope, $location, $apply, $ouServices, $rootScope,
    $par_index_factory,$rootScope, $coresFactory, $http, $enterpriseTypeServices,
    $careerServices) {

$rootScope.dataTreeMenuLeft = $rootScope.dataTreeMenuLeft || [];

$rootScope.dataTreeOu = $rootScope.dataTreeOu || []

$scope.data = {
    allOu: [],
    listProvince: {},
    listDistrict: {},
    listVillage: {},
    listEnterpriseType: {},
    listCareer: {},
    listStatus: {},
    search: {},
    ouInfo: {},
    idModalOu: '#modal_unit',
};

$scope.errors = {
    ou: {},
};
$scope.actions = {
    init() {
        $scope.actions.getAllProvider();
        $scope.actions.getAllDistrict();
        $scope.actions.getAllVillage();
        $scope.actions.getAllEnterpriseType();
        $scope.actions.getAllCareer();
        $scope.actions.getAllStatus();
        $scope.actions.getSingleEnterprise();
    },
    getAllProvider: function () {
        var params = {
        'status': 1
    }
    $http.get(SITE_ROOT + 'rest/province', {params: params})
    .then(function (resp) {
            $apply(function () {
            $scope.data.listProvince = resp.data;
        });
    }, function (error) {
        $coresFactory.httpErrors(error);
    });
    },
    getAllDistrict: function () {
        var params = {
            'status': 1
        }
        $http.get(SITE_ROOT + 'rest/district', {params: params})
        .then(function (resp) {
            $apply(function () {
                $scope.data.listDistrict = resp.data;
            });
        }, function (error) {
                $coresFactory.httpErrors(error);
        });
    },
    getAllVillage: function () {
        var params = {
            'status': 1
        }
        $http.get(SITE_ROOT + 'rest/village', {params: params})
        .then(function (resp) {
            $apply(function () {
                $scope.data.listVillage = resp.data;
            });
        }, function (error) {
                $coresFactory.httpErrors(error);
            });
    },
    getAllEnterpriseType: function () {
        var params = {
            'status': 1,
            'order_col': 'order'
        }
        $enterpriseTypeServices.getAll(params)
        .then(function (resp) {
            $apply(function () {
                $scope.data.listEnterpriseType = resp.data;
            });
        }, function (error) {
            $coresFactory.httpErrors(error);
        });
    },
    getAllCareer: function () {
        var params = {
            'status': 1,
        }
        $careerServices.getAll(params)
        .then(function (resp) {
            $apply(function () {
                $scope.data.listCareer = resp.data;
            });
        }, function (error) {
                $coresFactory.httpErrors(error);
            });
    },
    getAllStatus: function () {
            $ouServices.getAllStatus()
        .then(function (resp) {
        $apply(function () {
                $scope.data.listStatus = resp.data;
            });
        }, function (error) {
            $coresFactory.httpErrors(error);
        });
    },
    renderDepth: function (depth) {
        return $par_index_factory.renderDepthOu(depth);
    },
    getSingleEnterprise(){
        $rootScope.reloadPage = true;
        $ouServices.getSingleEnterprise($rootScope.loggedInUser.root_ou_id)
        .then(function (resp) {
            $apply(function () {
            $scope.data.ouInfo = resp.data;
            $rootScope.reloadPage = false;
        });

        }, function (error) {
            $coresFactory.httpErrors(error);
            $rootScope.reloadPage = false;
        });
    },
    editOu: function () {
        $rootScope.reloadPage = true;
        $scope.errors.ou = {};
        $ouServices.editEnterprise($scope.data.ouInfo)
        .then(function (resp) {
        $apply(function () {
            $.notify('Cập nhật thành công', 'success');
            $rootScope.reloadPage = false;
        });

        }, function (error) {
            $scope.errors.ou = $coresFactory.httpErrors(error);
            $rootScope.reloadPage = false;
        });
    },
    
};

$scope.actions.init();
});



