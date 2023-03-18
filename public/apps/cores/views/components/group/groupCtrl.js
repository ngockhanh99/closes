angular
  .module("myApp")
  .controller(
    "groupCtrl",
    function (
      $scope,
      $location,
      $http,
      $apply,
      $ouServices,
      $groupServices,
      $par_index_factory,
      $rootScope
    ) {
      $scope.data = {
        listPermit: [], //Danh sách quyền
        allUsers: [], //Danh sách người sử dụng
        allGroups: [],
        listRole: [],
        isShow: true,
        groupInfo: {
          group_id: 0,
          group_code: "",
          group_name: "",
          group_status: true,
          permit: [],
          users: [],
        },
        idModalGroupUser: "#modal_groupUser",
      };
      $scope.errors = {
        groupUser: {},
      };
      $scope.actions = {
        renderDepth: function (depth) {
          return $par_index_factory.renderDepthOu(depth);
        },
        initial: function () {
          $groupServices.getAll().then(
            function (resp) {
              $apply(function () {
                $scope.data.allGroups = resp.data.data;
                Object.entries(resp.data.listRole).forEach(([key, value]) =>
                  $scope.data.listRole.push(`${key}`)
                );
                console.log($scope.data.listRole);
              });
            },
            function (error) {
              $.notify(
                "Lấy danh sách đơn vị, phòng ban, nhóm người sử dụng, người sử dụng thất bại",
                "error"
              );
            }
          );
        },
        /**
         * Xóa trắng dữ liệu nhóm
         * @returns {undefined}
         */
        refreshGroupUserInfo: function () {
          $scope.errors.groupUser = {};
          $scope.data.groupInfo = {
            group_id: 0,
            group_code: "",
            group_name: "",
            group_status: '',
            permit: [],
            users: [],
          };
        },
        /**
         * Hiển thị modal cập nhật nhóm người sử dụng
         * @param {type} id
         * @returns {undefined}
         */
        showModalDetail: function (id) {
          $scope.actions.refreshGroupUserInfo();
          //active tab đầu tiên
          $("#modal_groupUser .nav.nav-tabs li:first-child a").tab("show");
          if (!id) {
            $scope.actions.checkPermit();
            $scope.actions.checkUser();
            $($scope.data.idModalGroupUser).modal("show");
            return;
          }
          $groupServices.getSingle(id).then(
            function (resp) {
              $apply(function () {
                $scope.data.groupInfo = resp.data;
                $scope.actions.checkPermit();
                $scope.actions.checkUser();
                $($scope.data.idModalGroupUser).modal("show");
              });
            },
            function (error) {
              $.notify("Lấy chi tiết nhóm người sử dụng thất bại", "error");
            }
          );
        },
        /**
         * Thêm mới phòng ban
         * @returns {undefined}
         */

        getPermitSelected: function () {
          var permit = [];
          for (var i = 0; i < $scope.data.listPermit.length; i++) {
            for (var j = 0; j < $scope.data.listPermit[i].permit.length; j++) {
              if ($scope.data.listPermit[i].permit[j].checked) {
                permit.push($scope.data.listPermit[i].permit[j].code);
              }
            }
          }
          return permit;
        },
        getUserSelected: function () {
          var users = [];
          for (var i = 0; i < $scope.data.allUsers.length; i++) {
            for (var j = 0; j < $scope.data.allUsers[i].users.length; j++) {
              if ($scope.data.allUsers[i].users[j].checked) {
                if (users.indexOf($scope.data.allUsers[i].users[j].id) === -1) {
                  users.push($scope.data.allUsers[i].users[j].id);
                }
              }
            }
          }
          return users;
        },

        insertGroupUser: function () {
          $rootScope.reloadPage = true
          $scope.errors.groupUser = {};
          $scope.data.groupInfo.permit = $scope.actions.getPermitSelected();
          $scope.data.groupInfo.users = $scope.actions.getUserSelected();
          $groupServices.insertGroupUser($scope.data.groupInfo).then(
            function (resp) {
              $apply(function () {
                $scope.actions.initial();
                $.notify("Thêm mới nhóm người sử dụng thành công", "success");
                $($scope.data.idModalGroupUser).modal("hide");
                console.log(1);
              });
            },
            function (error) {
              $scope.errors.groupUser = error.data.errors;
            }
          ).finally(() => $rootScope.reloadPage = false);
        },
        /**
         * chỉnh sửa nhóm NSD
         * @returns {undefined}
         */
        editGroupUser: function () {
          $rootScope.reloadPage = true
          $scope.data.groupInfo.permit = $scope.actions.getPermitSelected();
          $scope.data.groupInfo.users = $scope.actions.getUserSelected();

          $groupServices.editGroupUser($scope.data.groupInfo).then(
            function (resp) {
              $apply(function () {
                $scope.actions.initial();
                $.notify("Cập nhật nhóm người sử dụng thành công", "success");
                $($scope.data.idModalGroupUser).modal("hide");
              });
            },
            function (error) {
              $scope.errors.groupUser = error.data.errors;
            }
          ).finally(() => $rootScope.reloadPage = false);;
        },

        deleteGroup: function (id) {
          bootbox.confirm({
            message: "Bạn xác nhận xóa đối tượng đã chọn?",
            buttons: {
              cancel: {
                label: "Hủy bỏ",
              },
              confirm: {
                label: "Đồng ý",
              },
            },
            callback: function (isOk) {
              if (isOk) {
                $groupServices.destroy(id).then(
                  function (resp) {
                    $scope.actions.initial();
                    $.notify("Xóa thành công", "success");
                  },
                  function (error) {
                    $apply(function () {
                      $.notify("Xóa thất bại", "error");
                    });
                  }
                );
              }
            },
          });
        },
        checkPermit: function () {
          var promise = $scope.actions.loadAllPermit();
          promise.then(function () {
            for (var i = 0; i < $scope.data.listPermit.length; i++) {
              for (
                var j = 0;
                j < $scope.data.listPermit[i].permit.length;
                j++
              ) {
                if (
                  $scope.data.groupInfo.permit.indexOf(
                    $scope.data.listPermit[i].permit[j].code
                  ) != -1
                ) {
                  $scope.data.listPermit[i].permit[j].checked = true;
                } else {
                  $scope.data.listPermit[i].permit[j].checked = false;
                }
              }
            }
            $apply(function () {
              $scope.data.listPermit;
            });
          });
        },
        /**
         * Lấy danh sách quyền
         * @returns {Promise}
         */
        loadAllPermit: function () {
          return new Promise(function (resolve, reject) {
            //Load danh sách quyền sử dụng
            if ($scope.data.listPermit.length == 0) {
              $http.get(SITE_ROOT + "rest/permit").then(
                function (resp) {
                  $scope.data.listPermit = resp.data;
                  resolve();
                },
                function (error) {
                  $.notify("Lấy danh sách quyền thất bại", "error");
                  reject();
                }
              );
            } else {
              resolve();
            }
          });
        },

        checkUser: function () {
          $scope.actions.loadOuAndUser().then(
            function () {
              for (var i = 0; i < $scope.data.allUsers.length; i++) {
                if ($scope.data.allUsers[i].users) {
                  for (
                    var j = 0;
                    j < $scope.data.allUsers[i].users.length;
                    j++
                  ) {
                    if (
                      $scope.data.groupInfo.users.indexOf(
                        $scope.data.allUsers[i].users[j].id
                      ) != -1
                    ) {
                      $scope.data.allUsers[i].users[j].checked = true;
                    } else {
                      $scope.data.allUsers[i].users[j].checked = false;
                    }
                  }
                }
              }

              $apply(function () {
                $scope.data.allUsers;
              });
            },
            function (error) {}
          );
        },
        loadOuAndUser: function () {
          return new Promise(function (resolve, reject) {
            //Load danh sách quyền sử dụng
            if ($scope.data.allUsers.length == 0) {
              $ouServices.getOuAndUser().then(
                function (resp) {
                  $scope.data.allUsers = resp.data;
                  resolve();
                },
                function (error) {
                  $.notify(
                    "Lấy danh sách đơn vị/người sử dụng thất bại",
                    "error"
                  );
                  reject();
                }
              );
            } else {
              resolve();
            }
          });
        },

        userJoinGroup: function (user) {
          var index = $scope.data.groupInfo.users.indexOf(user.id);
          if (user.checked) {
            if (index != -1) {
              $scope.data.groupInfo.users.splice(index, 1);
            }
          } else {
            if (index == -1) {
              $scope.data.groupInfo.users.push(user.id);
            }
          }
          $scope.actions.checkUser();
        },
        checkGroupCode(group_code) {
          for (var i = 0; i < $scope.data.listRole.length; i++)
            if ($scope.data.listRole[i] == group_code) {
              return false;
            }
          return true;
        },
      };
      $scope.actions.initial();
    }
  );
