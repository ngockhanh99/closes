var app = angular.module('myApp', ['ui.router', 'bw.paging', 'oc.lazyLoad'])
        .service('Auth', ['$q', function ($q) {
                var d = $q.defer();
                return {
                    defer: d,
                    checkLogin: d.promise
                };
            }])
//Khác phục lỗi Possibly unhandled rejection trong angular 1.6*
app.config(['$qProvider', function ($qProvider) {
        $qProvider.errorOnUnhandledRejections(false);
    }]);

function configureTemplateFactory($provide) {
    // Set a suffix outside the decorator function
    var cacheBuster = Date.now().toString();
    function templateFactoryDecorator($delegate) {
        var fromUrl = angular.bind($delegate, $delegate.fromUrl);
        $delegate.fromUrl = function (url, params) {
            if (url !== null && angular.isDefined(url) && angular.isString(url)) {
                url += (url.indexOf("?") === -1 ? "?" : "&");
                url += "v=" + cacheBuster;
            }
            return fromUrl(url, params);
        };
        return $delegate;
    }
    $provide.decorator('$templateFactory', ['$delegate', templateFactoryDecorator]);
}
app.config(['$provide', configureTemplateFactory]);
