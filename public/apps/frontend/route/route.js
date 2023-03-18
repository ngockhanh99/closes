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
        .state('group', {
            url: '/group',
            controller: 'groupCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/group/group.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/views/components/ou/ouServices.js',
                            SITE_ROOT + 'apps/cores/views/components/group/groupServices.js',
                            SITE_ROOT + 'apps/cores/views/components/group/groupCtrl.js',
                        ]);
                    });
                }]
            }
        })
        .state('user', {
            url: '/user',
            controller: 'userCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/user/user.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/views/components/user/userCtrl.js',
                        ]);
                    });
                }]
            }
        })
        .state('update-my-profile', {
            url: '/update-my-profile',
            controller: 'updateMyProfileCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/updateMyProfile/updateMyProfile.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/css/ou.css',
                            SITE_ROOT + 'apps/cores/views/components/enterpriseType/enterpriseTypeServices.js',
                            SITE_ROOT + 'apps/cores/views/components/career/careerServices.js',
                            SITE_ROOT + 'apps/cores/views/components/ou/ouServices.js',
                            SITE_ROOT + 'apps/cores/views/components/updateMyProfile/updateMyProfileCtrl.js',
                        ]);
                    });
                }]
            }
        })
        .state('notification', {
            url: '/notification',
            controller: 'notificationCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/notification/notification.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/views/components/ou/ouServices.js',
                            SITE_ROOT + 'apps/cores/views/components/media/mediaServices.js',
                            SITE_ROOT + 'apps/cores/views/components/notification/notificationCtrl.js'

                        ]);
                    });
                }]
            }
        })
        .state('notification-add', {
            url: '/notification-add',
            controller: 'notificationCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/notificationAdd/notificationAdd.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/views/components/ou/ouServices.js',
                            SITE_ROOT + 'apps/cores/views/components/media/mediaServices.js',
                            SITE_ROOT + 'apps/cores/views/components/notification/notificationCtrl.js',
                            SITE_ROOT + 'apps/cores/views/components/notification/notificationServices.js'

                        ]);
                    });
                }]
            }
        })
        .state('media', {
            url: '/media',
            controller: 'mediaCtrl',
            templateUrl: SITE_ROOT + 'apps/cores/views/components/media/media.html',
            resolve: {
                loadMyCtrl: ['$ocLazyLoad', 'Auth', function ($ocLazyLoad, Auth) {
                    return Auth.checkLogin.then(() => {
                        return $ocLazyLoad.load([
                            SITE_ROOT + 'apps/cores/views/components/media/mediaServices.js',
                            SITE_ROOT + 'apps/cores/views/components/media/mediaCtrl.js',
                        ]);
                    });
                }]
            }
        })
        .state("config-system", {
            url: "/config-system",
            controller: "configSystemCtrl",
            templateUrl:
                SITE_ROOT +
                "apps/cores/views/components/config/configSystem/configSystem.html",
            resolve: {
                loadMyCtrl: [
                    "$ocLazyLoad",
                    "Auth",
                    function ($ocLazyLoad, Auth) {
                        return Auth.checkLogin.then(() => {
                            return $ocLazyLoad.load([
                                SITE_ROOT +
                                "apps/cores/views/components/config/configSystem/configSystemCtrl.js",
                            ]);
                        });
                    },
                ],
            },
        })
    ;
    // Without server side support html5 must be disabled.
//    $locationProvider.html5Mode(false);
});
