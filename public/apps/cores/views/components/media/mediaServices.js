angular.module('myApp').service('$mediaServices', function ($http) {
    return {

        allFiles: function (page, year)
        {
            var params = {
                page: page || 1,
                year: year || ''
            } ;
            return $http.get('rest/media', {params: params});
        },
        
        allYear:function()
        {
             return $http.get('rest/media/all-year');
        },
        
        insert:function(parram)
        {
             return $http.post('rest/media', parram);
        },
        delete:function(id)
        {
             return $http.delete('rest/media/' + id);
        }

    };
});