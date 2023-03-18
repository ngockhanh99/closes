app.directive('appHeader', function ($rootScope, $location, $window, $apply, $http, $coresFactory, $notificationServices, formatDateTime, $sce) {
    return {
        restrict: 'E',
        link: function (scope) {
            scope.loggedInUser = $rootScope.loggedInUser;
            scope.fullScreen = $rootScope.fullScreen;
            scope.changePasswordInfo = {
                user_login_name: '',
                password_old: '',
                password: '',
                password_confirmation: ''
            };

            scope.data = {
                notification: [],
                active_notify: '',
                count_new_notification: 0
            };
            scope.errors = {
                changePasswordInfo: {}
            };
            scope.actions = {
                resetNotificationCount: function () {
                    scope.data.count_new_notification = 0;
                },
                logout: function () {
                    $window.location.href = SITE_ROOT + "admin/auth/logout";
                },
                getPath: function (filepath) {
                    return SITE_ROOT + 'storage/' + filepath;

                },
                showModalChangePassword: function () {
                    scope.errors.changePasswordInfo = {};
                    scope.changePasswordInfo = {};
                    $('#changePassword').modal('show');
                },
                changePassword: function () {
                    scope.changePasswordInfo.user_login_name = $rootScope.loggedInUser.user_login_name;
                    $http.put(SITE_ROOT + '/rest/user/' + $rootScope.loggedInUser.id + '/changePassword', scope.changePasswordInfo)
                            .then(function () {
                                $.notify('Thay đổi mật khẩu thành công !', 'success');
                                $('#changePassword').modal('hide');
                            },
                                    // (xhr) => scope.errors.changePasswordInfo = $coresFactory.httpErrors(xhr)
                                function (err) {
                                scope.errors.changePasswordInfo = {};
                                console.log(err);
                                if(err.data.errors.password != undefined){
                                    scope.errors.changePasswordInfo.password = err.data.errors.password;
                                }
                                else{
                                    scope.errors.changePasswordInfo.password_old = err.data.errors;
                                }
                                    console.log(scope.errors.changePasswordInfo);


                                }
                            );
                },

                getNotify: function () {
                    if (!$rootScope.loggedInUser)
                        return;
                    $notificationServices.getAll()
                            .then(function (resp) {
                                $apply(function () {
                                    scope.data.notification = resp.data.data;
                                    for (var i = 0; i < scope.data.notification.length; ++i)
                                    {
                                        if (scope.data.notification[i].read_at == null)
                                            scope.data.count_new_notification++;
                                    }
                                });
                            }, function (error) {
                                $.notify('Lấy danh sách thông báo thất bại', 'error');
                            });
                },
                markNotifyAsRead: function (notify) {

                    $notificationServices.markNotifyAsRead(notify)
                            .then(function (resp) {
                                scope.actions.getNotify();
                            });
                },
                showDetail: function (notify) {
                    scope.data.active_notify = notify;
                    $('#notificationDetail').modal('show');
                    scope.actions.markNotifyAsRead(notify.id);
                },
                formatDateTime: function (date) {
                    return formatDateTime(date, 'DD/MM/YYYY H:m');
                }
            };
            $rootScope.printModal = function (id_print) {
                var elem = document.getElementById(id_print);
                var domClone = elem.cloneNode(true);
                var $printSection = document.getElementById("printSection");
                if (!$printSection)
                {
                    var $printSection = document.createElement("div");
                    $printSection.id = "printSection";
                    document.body.appendChild($printSection);
                }
                $printSection.innerHTML = "";
                $printSection.appendChild(domClone);
                window.print();
            };
            $rootScope.showFullScreen = function (id) {
                $rootScope.fullScreen = !$rootScope.fullScreen;
                scope.fullScreen = $rootScope.fullScreen;
                if (id)
                {
                    scope.dataFullScreen = $sce.trustAsHtml($('#' + id).html());
                }

            };
            scope.hideFullScreen = function () {
                $rootScope.fullScreen = !$rootScope.fullScreen;
                scope.fullScreen = $rootScope.fullScreen;
            }

            /**
             * Kiem tra qua han thoi gian trinh len
             * @param {type} enddate thời gian dự kiến hoàn thành
             * @param {type} date_done thời gian hoàn thành(Nếu chưa hoàn thành thì lấy thời gian hiện thại so sánh)
             * @returns {Boolean}
             */
            $rootScope.checkBizDoneDate = function (enddate, datedone) {
                var end_date = new Date(enddate);
                if (end_date === null)
                {
                    return true;
                }
                if (datedone)
                {
                    var q = new Date(datedone);

                }
                else
                {
                    var q = new Date();
                }

                if (datedone === null)
                {
                    return true;
                }


                var m = q.getMonth();
                var d = q.getDate();
                var y = q.getFullYear();
                var date_done = new Date(y, m, d);
                if (date_done > end_date)
                {
                    return false;
                }
                return true;
            };
            /**
             * Lấy độ dài của object
             * @param {type} obj
             * @returns {Number}
             */
            $rootScope.getSize = function (obj) {
                var size = 0, key;
                for (key in obj)
                {
                    if (obj.hasOwnProperty(key))
                        size++;
                }
                return size;
            };
            scope.$watch(function () {
                return $rootScope.loggedInUser;
            }, function (newVal, oldVal) {
                if (newVal && newVal != oldVal && Object.keys(newVal).length !== 0 && newVal.constructor === Object)
                {
                    scope.actions.getNotify();
                    scope.userInfo = $rootScope.loggedInUser;
                }
            }, true);

        },
        templateUrl: 'apps/cores/views/directives/header/header.php',
        scope: {}
    };
})
