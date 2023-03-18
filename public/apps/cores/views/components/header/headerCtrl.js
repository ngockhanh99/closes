angular.module('myApp').controller("headerCtrl", function ($scope, $rootScope, $location, $window, $apply, $http, $coresFactory, formatDateTime, $sce) {
    $scope.loggedInUser = $rootScope.loggedInUser;
    $scope.fullScreen = $rootScope.fullScreen;
    $rootScope.socket = {} //io.connect('http://localhost:3000/')
    $rootScope.alertChat = false
    $scope.changePasswordInfo = {
        user_login_name: '',
        password_old: '',
        password: '',
        password_confirmation: ''
    };
    $scope.myProfile = {
        detail: {
            province_id: "",
            district_id: "",
            village_id: "",
            enterprise_type: "",
            enterprise_spec: "",
        }
    }
    $scope.data = {
        notification: [],
        active_notify: '',
        count_new_notification: 0,
        listProvince: {},
        listDistrict: {},
        listVillage: {},
        listType: {},
        listSpec: {},
    };
    $scope.errors = {
        changePasswordInfo: {}
    };
    $scope.$watch(function () {
        return $location.path()
    }, function (value) {
    });
    $scope.actions = {
        logout: function () {
            $window.location.href = SITE_ROOT + "admin/auth/logout";
        },
        getPath: function (filepath) {
            return SITE_ROOT + 'storage/' + filepath;

        },
        getUser() {
            $http.get(SITE_ROOT + 'rest/change-profile/get-user')
                .then(response => {
                    $scope.myProfile = response.data
                    $scope.myProfile.user_role = filterRole($scope.myProfile.user_role)
                    $scope.actions.changeDistrict()
                    $scope.actions.changeVillage()

                    $scope.myProfile.personal_name = getUserMetaByKey('personal_name')
                    $scope.myProfile.address = getUserMetaByKey('user_address')
                    $scope.myProfile.job = getUserMetaByKey('user_job_title')
                    $scope.myProfile.enterprise_website = getUserMetaByKey('enterprise_website')
                })
        },

        formatDateTime: function (date) {
            return formatDateTime(date, 'DD/MM/YYYY H:m');
        },
    };

    $rootScope.printModal = function (id_print) {
        var elem = document.getElementById(id_print);
        var domClone = elem.cloneNode(true);
        var $printSection = document.getElementById("printSection");
        if (!$printSection) {
            $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }
        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    };
    $rootScope.showFullScreen = function (id) {
        $rootScope.fullScreen = !$rootScope.fullScreen;
        $scope.fullScreen = $rootScope.fullScreen;
        if (id) {
            $scope.dataFullScreen = $sce.trustAsHtml($('#' + id).html());
        }

    };
    $scope.hideFullScreen = function () {
        $rootScope.fullScreen = !$rootScope.fullScreen;
        $scope.fullScreen = $rootScope.fullScreen;
    }

    /**
     * Kiem tra qua han thoi gian trinh len
     * @param {type} enddate thời gian dự kiến hoàn thành
     * @param {type} date_done thời gian hoàn thành(Nếu chưa hoàn thành thì lấy thời gian hiện thại so sánh)
     * @returns {Boolean}
     */
    $rootScope.checkBizDoneDate = function (enddate, datedone) {
        var end_date = new Date(enddate);
        if (end_date === null) {
            return true;
        }
        if (datedone) {
            var q = new Date(datedone);

        } else {
            var q = new Date();
        }

        if (datedone === null) {
            return true;
        }


        var m = q.getMonth();
        var d = q.getDate();
        var y = q.getFullYear();
        var date_done = new Date(y, m, d);
        if (date_done > end_date) {
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
        for (key in obj) {
            if (obj.hasOwnProperty(key))
                size++;
        }
        return size;
    };
    $rootScope.getMetaValue = function (data = [], key_word = '') {
        if (data.length == 0) return
        return data.find(item => item.user_meta_key == key_word).user_meta_value
    };
    $scope.$watch(function () {
        return $rootScope.loggedInUser;
    }, function (newVal, oldVal) {
    }, true);

    function preViewImage() {
        const input_avatar = document.getElementById('input_avatar')
        const button_avatar = document.getElementById('button_avatar')
        const show = document.getElementById('show_avatar')
        const remove = document.getElementById('remove_avatar')

        button_avatar.onclick = () => input_avatar.click()

        input_avatar.onchange = () => {
            if (input_avatar.files[0]) {
                show.src = URL.createObjectURL(input_avatar.files[0])
            }
        }
        remove.onclick = () => {
            show.src = ''
            input_avatar.value = null
        }
    }

    function getUserMetaByKey(key) {
        for (let item of $scope.myProfile.user_meta) {
            if (item.user_meta_key == key) {
                return item.user_meta_value
            }
        }

    }
});
