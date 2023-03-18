angular.module('myApp').controller("mediaCtrl", function ($scope, $apply, $par_index_factory, $mediaServices, $location, formatDateTime) {
    $scope.data = {
        fileInfo: {
            filename: '',
            filepath: '',
            filext: ''
        },
        allYear: [],
        allFiles: []//mảng chứa danh sách file
    }
    $scope.errors = {
    };
    $scope.actions = {

        init: function ()
        {
            var page = $location.search().page ? $location.search().page : 1;
            $mediaServices.allFiles(page)
                    .then(
                            function (resp) {
                                $apply(function () {
                                    $scope.data.allFiles = resp.data;
                                });
                            },
                            function (error) {
                                $.notify('Xảy ra lỗi, Bạn vui lòng tải lại trang sau đó thao tác lại.')
                            });
            $mediaServices.allYear()
                    .then(
                            function (resp) {
                                $apply(function () {
                                    $scope.data.allYear = resp.data;
                                });
                            },
                            function (error) {
                                $.notify('Xảy ra lỗi, Bạn vui lòng tải lại trang sau đó thao tác lại.')
                            });

        },
        uploadFile: function (data, tagsUpload, tagsProgress, tagsBtnUpload, tagsProcess)
        {
            $par_index_factory.uploadFile(data, tagsUpload, tagsProgress, tagsBtnUpload, tagsProcess, () => {
                $apply(function () {
                    $scope.actions.init();
                })
            });
        },
        gotoPage: function (page)
        {
            $location.search('page', page);
        },
        formatDateTime: function (date)
        {
            return  formatDateTime(date, 'DD/MM/YYYY H:m');
        }
    }
    $scope.actions.init();
});