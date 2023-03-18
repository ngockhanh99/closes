app.config(function ($stateProvider, $locationProvider, $urlRouterProvider, $ocLazyLoadProvider) {
    // We configure ocLazyLoad to use the lib script.js as the async loader
    $ocLazyLoadProvider.config({
        debug: false,
        events: true,
    });

    $urlRouterProvider.otherwise("/");
    $locationProvider.hashPrefix('!');
    // You can also load via resolve
    $stateProvider
        .state('/', {
            url: "/", // root route
            controller: 'dashboardCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/dashboard/dashboard.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load(SITE_ROOT + 'apps/cores/views/components/dashboard/dashboardCtrl.js');
                    });
                }]
            }
        })
    ;
    // Without server side support html5 must be disabled.
//    $locationProvider.html5Mode(false);
});
