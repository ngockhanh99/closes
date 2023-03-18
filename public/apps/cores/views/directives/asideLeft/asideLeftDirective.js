app.directive('asideLeft', function ($http, $location, $apply) {
    return {
        restrict: 'E',
        link: function (scope)
        {
            var path = $location.path();
            scope.menuLeftSelected = path.replace('/', '');
            scope.actions = {
                setMenuSelected: function(){
                    var path = $location.path();
                    var arr_path = path.split('/');
                    scope.menuLeftSelected = arr_path.filter(function (el) {
                        return el != null && el != '';
                    });
                },
                checkActive: function(key) {
                    scope.actions.setMenuSelected();
                    if(typeof scope.menuLeftSelected[0] === 'undefined'){
                        return false;
                    }
                    if(scope.menuLeftSelected[0] == key){
                        return true;
                    }
                    return false;
                },
                checkActiveChild: function(key, keyChild) {
                    scope.actions.setMenuSelected();
                    if(typeof scope.menuLeftSelected[0] === 'undefined' || typeof scope.menuLeftSelected[1] === 'undefined'){
                        return false;
                    }
                    if(scope.menuLeftSelected[0] == key && scope.menuLeftSelected[1] == keyChild){
                        return true;
                    }
                    return false;
                },
                getUrl(key, permit) {
                    if(key === 'admin-portal')
                        return SITE_ROOT + 'admin-portal';
                    if(permit)
                        return 'javascript:void(0)';
                    return 'admin#!/' + key;
                },
                changeMenu(key, permit){
                    if(permit)
                        return ;
                    if(key.indexOf("foo")){
                        scope.actions.getDataMenu();
                    }
                },
                getDataMenu() {
                    $http.get(SITE_ROOT + 'rest/menu')
                        .then(function (resp) {
                            scope.asideLeftInfo = resp.data;
                            $apply(function () {
                                //Set up the object
                                $("#side-menu").metisMenu();
                            });

                        });
                },
            };
            scope.actions.getDataMenu();
        },
        templateUrl: 'apps/cores/views/directives/asideLeft/asideLeft.html',
        scope: {}
    };
})
