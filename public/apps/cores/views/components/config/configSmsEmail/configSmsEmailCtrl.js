angular.module('myApp').controller("configSmsEmailCtrl", function ($scope, $location, $http, $apply) {
    console.log(11111);

    $scope.actions = {
        init: function () {
            $rootScope.reloadPage = true;
            $http.get(SITE_ROOT + 'sipas/config/allTypeSipasReport')
                .then(
                    function (resp) {
                        $apply(function () {
                            $rootScope.reloadPage = false;

                            $scope.data.allTypeSipasReport = resp.data;
                            $scope.actions.getAllConfig();
                        });
                    },
                    function (error)
                    {
                        $.notify(error.data.message, 'error');
                    }
                );
        }
    };

});
