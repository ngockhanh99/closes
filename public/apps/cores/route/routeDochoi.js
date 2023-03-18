app.config(function ($stateProvider) {
    $stateProvider
        .state("dochoi-danhmuc", {
            url: "/dochoi-danhmuc",
            controller: "danhmucCtrl",
            templateUrl: SITE_ROOT + "apps/cores/views/components/dochoi/danhmuc/danhmuc.html",
            resolve: {
                loadMyCtrl: [
                    "$ocLazyLoad",
                    "Auth",
                    function ($ocLazyLoad, Auth) {
                        return Auth.checkLogin.then(() => {
                            return $ocLazyLoad.load([
                                SITE_ROOT + "apps/cores/views/components/dochoi/danhmuc/danhmucCtrl.js?v=" + APP_VERSION,
                            ]);
                        });
                    },
                ],
            },
        })
        .state("dochoi-mau", {
            url: "/dochoi-mau",
            controller: "mauCtrl",
            templateUrl: SITE_ROOT + "apps/cores/views/components/dochoi/mau/mau.html",
            resolve: {
                loadMyCtrl: [
                    "$ocLazyLoad",
                    "Auth",
                    function ($ocLazyLoad, Auth) {
                        return Auth.checkLogin.then(() => {
                            return $ocLazyLoad.load([
                                SITE_ROOT + "apps/cores/views/components/dochoi/mau/mauCtrl.js?v=" + APP_VERSION,
                            ]);
                        });
                    },
                ],
            },
        })
        .state("dochoi-loaisanpham", {
            url: "/dochoi-loaisanpham",
            controller: "loaisanphamCtrl",
            templateUrl: SITE_ROOT + "apps/cores/views/components/dochoi/loaisanpham/loaisanpham.html",
            resolve: {
                loadMyCtrl: [
                    "$ocLazyLoad",
                    "Auth",
                    function ($ocLazyLoad, Auth) {
                        return Auth.checkLogin.then(() => {
                            return $ocLazyLoad.load([
                                SITE_ROOT + "apps/cores/views/components/dochoi/loaisanpham/loaisanphamCtrl.js?v=" + APP_VERSION,
                            ]);
                        });
                    },
                ],
            },
        })
        .state("dochoi-san-pham", {
            url: "/dochoi-san-pham",
            controller: "sanphamCtrl",
            templateUrl:
                SITE_ROOT + "apps/cores/views/components/dochoi/sanpham/sanpham.php",
            resolve: {
                loadMyCtrl: [
                    "$ocLazyLoad",
                    "Auth",
                    function ($ocLazyLoad, Auth) {
                        return Auth.checkLogin.then(() => {
                            return $ocLazyLoad.load([
                                SITE_ROOT +
                                "apps/cores/views/components/dochoi/sanpham/sanphamCtrl.js?v=" + APP_VERSION,
                            ]);
                        });
                    },
                ],
            },
        })
});
