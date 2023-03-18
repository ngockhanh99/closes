angular.module('myApp').controller("configSystemCtrl", function ($scope, $location, $http, $apply, $rootScope) {
    $scope.data = {
        config: {
        }
    }

    $scope.actions = {
        init: function () {
            $rootScope.reloadPage = true;
            $http.get(SITE_ROOT + 'rest/options')
                .then(
                    function (resp) {
                        $apply(function () {
                            $rootScope.reloadPage = false;
                            $scope.data.config = resp.data;
                        });
                    },
                    function (error)
                    {
                        $rootScope.reloadPage = false;
                        $.notify(error.data.message, 'error');
                    }
                );
        },
        update: function () {
            $rootScope.reloadPage = true;
            $http.post(SITE_ROOT + 'rest/options', $scope.data.config)
                .then(
                    function (resp) {
                        $rootScope.reloadPage = false;
                        $scope.actions.init();
                    },
                    function (error) {
                        $rootScope.reloadPage = false;
                        $.notify(error.data.message, 'error');
                    }
                );
        }
    };
    $scope.actions.init();

});
