angular.module("myApp").service("$groupServices", function ($http) {
  return {
    insertGroupUser: function (data, ou_parent_id) {
      var params = {
        group_name: data.group_name,
        group_code: data.group_code,
        permit: data.permit,
        users: data.users,
      };
      params.group_status = data.group_status ? 1 : 0;
      return $http.post(SITE_ROOT + "rest/group", params);
    },
    editGroupUser: function (data, ou_parent_id) {
      var params = {
        group_code: data.group_code,
        group_name: data.group_name,
        permit: data.permit,
        users: data.users,
      };
      params.group_status = data.group_status ? 1 : 0;
      return $http.put(SITE_ROOT + "rest/group/" + data.group_id, params);
    },
    getSingle: function (group_id) {
      return $http.get(SITE_ROOT + "rest/group/" + group_id);
    },
    getAll: function (page) {
      return $http.get(SITE_ROOT + "rest/group");
    },
    destroy: function (id) {
      return $http.delete(SITE_ROOT + "rest/group/" + id);
    },
  };
});
