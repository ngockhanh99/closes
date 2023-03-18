var app = angular.module('myApp', ['ui.router', 'bw.paging', 'oc.lazyLoad'])
        .service('Auth', ['$q', function ($q) {
                var d = $q.defer();
                return {
                    defer: d,
                    checkLogin: d.promise
                };
            }])
        .run(['$q', '$rootScope', '$location', '$apply', '$loginServices', 'Auth', function ($q, $rootScope, $location, $apply, $loginServices, Auth)
            {
            }]);
//Khác phục lỗi Possibly unhandled rejection trong angular 1.6*
app.config(['$qProvider', function ($qProvider) {
        $qProvider.errorOnUnhandledRejections(false);
    }]);
