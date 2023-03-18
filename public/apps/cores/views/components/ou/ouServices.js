 angular.module('myApp').service('$ouServices', function ($http) {
    return {
        /**
         * Lấy danh sách NSD,Phòng ban, đơn vị
         * @returns {unresolved}
         */
        getAll: function (params) {
            return $http.get('rest/ou', {params: params});
        },
        getAllNested: function () {
            return $http.get('rest/ou/nested');
        },
        allOuAndUser: function (ou_id) {
            return $http.get('rest/ou/allOuAndUser/' + ou_id);
        },
        getSingle: function (ou_id) {
            return $http.get('rest/ou/' + ou_id);
        },

        insertOu: function (ouInfo) {
            var params = {
                ou_name: ouInfo.ou_name,
                parent_id: ouInfo.parent_id,
                ou_level: ouInfo.ou_level,
                ou_order: ouInfo.ou_order,
                latitude: ouInfo.latitude,
                longitude: ouInfo.longitude,
                radius: ouInfo.radius,
                email: ouInfo.email,
                sms: ouInfo.sms
            };
            return $http.post('rest/ou', params);
        },
        editOu: function (ouInfo) {
            var params = {
                parent_id: ouInfo.parent_id,
                ou_name: ouInfo.ou_name,
                ou_level: ouInfo.ou_level,
                ou_order: ouInfo.ou_order,
                latitude: ouInfo.latitude,
                longitude: ouInfo.longitude,
                radius: ouInfo.radius,
                email: ouInfo.email,
                sms: ouInfo.sms,
            };
            return $http.put('rest/ou/' + ouInfo.ou_id, params);
        },
        delete: function (id) {
            return $http.delete('rest/ou/' + id);
        },

        //######################## đơn vị, phòng ban ###################################
        getOuAndOuSurvey: function (ou_id, ou_survey_id) {
            return $http.get('rest/ou/allOuAndOuSurvey/' + ou_id, {params: {ou_survey_id: ou_survey_id}});
        },
        //####################Doanh nghiệp#############
        insertEnterprise: function (params) {
            return $http.post('rest/enterprise', params);
        },
        checkImportExcel: function (params) {
            return $http.post('rest/enterprise/check', params);
        },
        editEnterprise: function (params) {
            return $http.put('rest/enterprise/' + params.ou_id, params);
        },
        getAllStatus(){
            return $http.get('rest/enterprise/status');
        },
        getSingleEnterprise: function (ou_id) {
            return $http.get('rest/enterprise/' + ou_id);
        },
        verifyEnterprise: function (id) {
            return $http.post('rest/enterprise/verify/' + id);
        },
    };
});
