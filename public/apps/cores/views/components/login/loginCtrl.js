angular.module('myApp').controller("loginCtrl", function ($scope, $location, $rootScope, $http, $apply, $window, $loginServices, $coresFactory) {
    $rootScope.headHide = true;
    $scope.data = {
        user_login_name: '',
        password: ''
    };
    $scope.errors = {};
    $scope.actions = {
        login: function () {
            $loginServices.login($scope.data.user_login_name, $scope.data.password).then(function (resp) {
                $apply(function () {
                    $rootScope.loggedInUser = resp.data;
                    $location.path("/");
                });
            },
                 function (errors) {
                    if(errors.status === 419){
                        $window.href.location("/");
                    }
                     $scope.errors = errors.data;
                 }
                 // (errors) => $scope.errors = $coresFactory.httpErrors(errors)
            );


        },

    }

});
