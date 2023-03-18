app.directive('paginateDir', function ($http, $location, $apply) {
    return {
        restrict: 'E',
        link: function (scope, attrs) {
            scope.actions = {
                pagingAction(page) {
                    scope.page = page;
                    $apply(function () {
                        scope.pagingAction();
                    })
                }
            };
        },
        templateUrl: 'apps/cores/views/directives/paginate/paginate.html',
        scope: {
            page: '=page',
            pageSize: '=pageSize',
            total: '=total',
            pagingAction: '&pagingAction',

        }
    };
})
