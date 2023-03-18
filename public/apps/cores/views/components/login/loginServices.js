angular.module('myApp').service('$loginServices', function ($http) {
    return {
        login: function (user_login_name, password)
        {
            return $http.post('admin/auth/login', {user_login_name: user_login_name, password: password}, headerRequest)
        },
        logout: function ()
        {
            return $http.get('admin/auth/logout', headerRequest);
        },
        getUser: function ()
        {
            return $http.get('rest/user/getUser', headerRequest);
        }
    };
});