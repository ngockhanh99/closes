angular.module('myApp').controller("configConnectCtrl", function ($scope, $location, $http, $apply) {
    $scope.data = {
        config: {

        }
    }

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
        },
        getPath: function () {
            return SITE_ROOT + 'api/docs';
        },
    };

});
