angular.module('myApp').controller('dashboardCtrl', function ($scope, $http, $apply, $location) {
    $scope.data = {};
    $scope.actions = {
        init() {
            $http.post(SITE_ROOT+'dochoi/dashboard').then((res)=>$scope.data.singleData = res.data)
        },
        update(){
            $http.post(SITE_ROOT+'dochoi/dashboard/update',$scope.data.singleData).then(()=>$scope.actions.init())
        }
    };
    $scope.actions.init();
});
