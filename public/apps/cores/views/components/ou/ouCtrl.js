angular.module('myApp').controller("ouCtrl", function ($scope, $location, $apply, $ouServices, $rootScope,
                                                       $par_index_factory, $coresFactory, $http, $enterpriseTypeServices,
                                                       $careerServices) {
    $rootScope.dataTreeMenuLeft = $rootScope.dataTreeMenuLeft || [];
    $rootScope.dataTreeOu = $rootScope.dataTreeOu || []

    $scope.data = {
        allOu: [],
        listProvince: {},
        listDistrict: {},
        listVillage: {},
        listEnterpriseType: {},
        listCareer: {},
        listStatus: {},
        search: {},
        ouInfo: {},
        idModalOu: '#modal_unit',
    };

    $scope.errors = {
        ou: {},
    };
    $scope.actions = {
        init() {
            $scope.actions.getAllProvider();
            $scope.actions.getAllDistrict();
            $scope.actions.getAllVillage();
            $scope.actions.getAllEnterpriseType();
            $scope.actions.getAllCareer();
            $scope.actions.getAllStatus();
            $scope.actions.resetFillter();

        },
        /**
         * Lấy danh sách đơn vị, phòng ban
         * @returns {undefined}
         */
        getAll: function () {
            $ouServices.getAll($scope.data.search)
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.allOu = resp.data;
                        $scope.data.search.total = resp.data.total;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllProvider: function () {
            var params = {
                'status': 1
            }
            $http.get(SITE_ROOT + 'rest/province', {params: params})
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listProvince = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllDistrict: function () {
            var params = {
                'status': 1
            }
            $http.get(SITE_ROOT + 'rest/district', {params: params})
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listDistrict = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllVillage: function () {
            var params = {
                'status': 1
            }
            $http.get(SITE_ROOT + 'rest/village', {params: params})
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listVillage = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllEnterpriseType: function () {
            var params = {
                'status': 1,
                'order_col': 'order'
            }
            $enterpriseTypeServices.getAll(params)
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listEnterpriseType = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllCareer: function () {
            var params = {
                'status': 1,
            }
            $careerServices.getAll(params)
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listCareer = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        getAllStatus: function () {
            $ouServices.getAllStatus()
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.listStatus = resp.data;
                    });
                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },

        sorting(order_col) {
            $scope.data.search.direction = $scope.data.search.direction == 'asc' ? 'desc' : 'asc';
            if ($scope.data.search.order_col !== order_col) {
                $scope.data.search.direction = 'asc'
            }
            $scope.data.search.order_col = order_col;
            $scope.actions.getAll();
        },
        classSorting(order_col) {
            if ($scope.data.search.order_col != order_col) {
                return '';
            }
            if ($scope.data.search.direction != 'asc') {
                return 'sorting_asc';
            }
            return 'sorting_desc';
        },
        gotoPage: function (page) {
            $location.search('page', page);
            $scope.actions.getAll();
        },
        resetFillter() {
            $scope.data.search = {
                keyword: '',
                rank: '',
                province_id: '',
                district_id: '',
                village_id: '',
                enterprise_type_id: '',
                career_id: '',
                ou_status: '',
                ou_level: 'CAP_SO',
                order_col: 'ou_name',
                direction: 'asc',
                limit: 20,
                page: 1,
                total: 0
            };
            $scope.actions.getAll();
        },
        renderDepth: function (depth) {
            return $par_index_factory.renderDepthOu(depth);
        },

        /**
         * Xóa trắng dữ liệu đơn vị
         * @returns {undefined}
         */
        refreshOuInfo: function () {
            $scope.errors.ou = {};
            $scope.data.ouInfo = {
                ou_id: '',
                ou_name: '',
                enterprise_type_id: '',
                career_id: '',
                tax_code: '',
                province_id: '',
                district_id: '',
                village_id: '',
                address: '',
                phone: '',
                fax: '',
                email: '',
                ou_status: 1,
                other_info: {
                    director_name: '',
                    director_phone: '',
                    director_email: '',
                    accountant_name: '',
                    accountant_phone: '',
                    accountant_email: '',
                    HRM_name: '',
                    HRM_phone: '',
                    HRM_email: '',
                }
            };
        },
        /**
         * Hiển thị modal cập nhật đơn vị
         * @param {type} id
         * @returns {undefined}
         */
        showModelOu: function (id) {
            $scope.actions.refreshOuInfo();
            if (!id) {
                $($scope.data.idModalOu).modal('show');
                return;
            }
            $ouServices.getSingleEnterprise(id)
                .then(function (resp) {
                    $apply(function () {
                        $scope.data.ouInfo = resp.data;
                        $($scope.data.idModalOu).modal('show');
                    });

                }, function (error) {
                    $coresFactory.httpErrors(error);
                });
        },
        insertOu: function () {
            $scope.errors.ou = {};
            $ouServices.insertEnterprise($scope.data.ouInfo)
                .then(function (resp) {
                    $apply(function () {
                        $scope.actions.getAll();
                        $.notify('Thêm mới thành công', 'success');
                        $($scope.data.idModalOu).modal('hide');
                    });

                }, function (error) {
                    $scope.errors.ou = error.data.errors;
                });
        },
        editOu: function () {
            $scope.errors.ou = {};
            $ouServices.editEnterprise($scope.data.ouInfo)
                .then(function (resp) {
                    $apply(function () {
                        $scope.actions.getAll();
                        $.notify('Cập nhật thành công', 'success');
                        $($scope.data.idModalOu).modal('hide');
                    });

                }, function (error) {
                    $scope.errors.ou = $coresFactory.httpErrors(error);
                });
        },
        deleteOu: function (id) {
            bootbox.confirm({
                message: "Bạn xác nhận xóa đối tượng đã chọn?",
                buttons: {
                    cancel: {
                        label: 'Hủy bỏ'
                    },
                    confirm: {
                        label: 'Đồng ý'
                    }
                },
                callback: function (isOk) {
                    if (isOk) {
                        $ouServices.delete(id)
                            .then(function () {
                                $scope.actions.getAll();
                                $.notify('Xóa đối tượng đã lựa chọn thành công', 'success');
                            }, function (error) {
                                $coresFactory.httpErrors(error);
                            });
                    }
                }
            });
        },
        exportExcel: function (){
            $http.post('rest/report/exportExcel11',$scope.data.search)
            .then(function (response){
                window.open(SITE_ROOT + response.data);
            },function (error){
                console.log(error);
            });
        }
    };

    $scope.actions.init();
});



