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
                $rootScope.$on("$locationChangeStart", function (event, toState, toParams)
                {
                    Auth.defer = $q.defer();
                    Auth.checkLogin = Auth.defer.promise;
                    $rootScope.crrPage = $location.$$path;
                    //Check is logged
                    $loginServices.getUser()
                            .then(function (resp) {
                                $apply(function () {
                                    $rootScope.loggedInUser = resp.data;
                                    Auth.defer.resolve();
                                });
                                if ($location.$$path == 'admin/login')
                                {
                                    $location.path("/admin");
                                }
                            }, function (xhr) {
                                if(xhr.status == 401){
                                    location.href = SITE_ROOT + "admin/login";
                                }
                            });
                });

            }]);
//Khác phục lỗi Possibly unhandled rejection trong angular 1.6*
app.config(['$qProvider', function ($qProvider) {
        $qProvider.errorOnUnhandledRejections(false);
    }]);

function configureTemplateFactory($provide) {
    function templateFactoryDecorator($delegate) {
        var fromUrl = angular.bind($delegate, $delegate.fromUrl);
        $delegate.fromUrl = function (url, params) {
            if (url !== null && angular.isDefined(url) && angular.isString(url)) {
                url += (url.indexOf("?") === -1 ? "?" : "&");
                url += "v=" + APP_VERSION;
            }
            return fromUrl(url, params);
        };
        return $delegate;
    }
    $provide.decorator('$templateFactory', ['$delegate', templateFactoryDecorator]);

}
app.config(['$provide', configureTemplateFactory]);
