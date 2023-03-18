var myApp = angular.module("myApp", []);
myApp.controller("villageCtrl", function ($scope, $http, $apply) {
  $scope.data = {
    listData: {},
    listDistrict: {},
    singleVillage: {
      district_id: "",
    },
    statusInsert: true,
  };
  $scope.search = {
    keyword: "",
    limit: '20',
    page: 1,
    total: 1,
  };
  $scope.modal = {
    show: function () {
      $("#modal_single").modal("show");
    },
    hide: function () {
      $("#modal_single").modal("hide");
    },
  };
  $scope.actions = {
    initial() {
      $scope.actions.getAll();
      $scope.actions.getDistict();
      
    },
    getAll() {
      $http.get(SITE_ROOT + "rest/village", { params: $scope.search }).then(
        function (resp) {
          $apply(function () {
            $scope.search.total = resp.data.total;
            $scope.data.listData = resp.data.data;
          });
        },
        function (errors) {
          $.notify("Lấy thông tin lao động thất bại!", "error");
        }
      );
    },
    getDistict() {
      $http.get(SITE_ROOT + "rest/district").then(
        function (resp) {
          $scope.data.listDistrict = resp.data;
        },
        function (errors) {
          $.notify("Lấy thông tin lao động thất bại!", "error");
        }
      );
    },
    showModalVillage(status, index) {
      $scope.errors = {};
      $scope.data.statusInsert = status;
      $scope.data.singleVillage = { ...$scope.data.listData[index] };
      $scope.modal.show();
    },
    insertVillage() {
      $http
        .post(SITE_ROOT + "rest/village/insert", $scope.data.singleVillage)
        .then(
          function (resp) {
            $apply(function () {
              $scope.actions.initial();
              $.notify("Thêm mới thành công!", "success");
              $scope.modal.hide();
            });
          },
          function (errors) {
            $scope.errors = errors.data.errors;
            $.notify("Thêm mới thất bại!", "error");
          }
        );
    },
    updateVillage(id) {
      $http
        .put(SITE_ROOT + "rest/village/update/" + id, $scope.data.singleVillage)
        .then(
          function (resp) {
            $apply(function () {
              $scope.actions.initial();
              $.notify("Thêm mới thành công!", "success");
              $scope.modal.hide();
            });
          },
          function (errors) {
            $scope.errors = errors.data.errors;
            $.notify("Thêm mới thất bại!", "error");
          }
        );
    },
    deleteVillage(id) {
      let checkDelete = confirm("Bạn có muốn xóa đối tượng đã chọn?");
      if (!checkDelete) return;

      $http.delete(SITE_ROOT + "rest/village/delete/" + id).then(
        () => {
          $scope.actions.getAll();
          $.notify("Xóa thành công!", "success");
        },
        () => {
          $.notify("Xóa thất bại!", "error");
        }
      );
    },
    search() {
      $scope.search.page = 1;
      $scope.actions.getAll();
    },
    changePerPage(){
      $scope.search.page=1;
      $scope.actions.getAll();
    },
    gotoPage(page) {
      $scope.search.page = page;
      $scope.actions.getAll();
    },
  };
 
  $scope.actions.initial();
});
