angular.module('myApp').controller("userCtrl", function ($scope, $http, $rootScope) {
    $scope.data = {
        listUser: {},
        singleUser: {
            listPermit: [],
        },
        listRole: {},
        listPermit: {},
        listGroup: {},
        listProvince: {},
        listDistrict: {},
        listVillage: {},
        listType: {},
        listSpec: {},
        isInsert: true,
    };

    $scope.errors = {
    };
    $scope.actions = {
        initial(){
            $scope.actions.getAll()
            $scope.actions.getProvince()
            $scope.actions.getType()
            $scope.actions.getSpec()
            $scope.actions.getGroup()
        },
        getAll(){
            $rootScope.reloadPage = true
            $http.get(SITE_ROOT + 'rest/mca-user/list-user')
                .then(response => {
                    $scope.data.listUser = response.data.listUser
                    $scope.data.listRole = response.data.listRole
                    $scope.data.listPermit = response.data.listPermit
                })
                .catch(() => $.notify('Lấy danh sách người sử dụng thất bại!','error'))
                .finally(() => $rootScope.reloadPage = false)
        },
        showModalUser(status,index){
            const preview_avatar = document.getElementById('user_preview_image')
            $scope.errors = {}
            $scope.data.isInsert = status
            $scope.data.singleUser = {...$scope.data.listUser[index]}
            if(status) {
                $scope.data.singleUser.user_status = 1
            }
            $scope.actions.changeDistrict()
            $scope.actions.changeVillage()
            getUserMeta($scope.data.singleUser.user_meta)
            $('#modal_user').modal('show')
        },
        insertUser(){
            $rootScope.reloadPage = true
            $scope.data.singleUser.listGroup = getListGroupId($scope.data.listGroup)
            setPermitUser()
            $http.post(SITE_ROOT + 'rest/mca-user/insert-user',$scope.data.singleUser)
                .then(() => {
                    $scope.actions.getAll()
                    $('#modal_user').modal('hide')
                    $.notify('Thêm mới người sử dụng thành công!','success')
                })
                .catch(error => {
                    $scope.errors = error.data.errors
                    $.notify('Thêm mới người sử dụng thất bại!','error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        updateUser(){
            $rootScope.reloadPage = true
            $scope.data.singleUser.listGroup = getListGroupId($scope.data.listGroup)
            setPermitUser()
            $http.put(SITE_ROOT + 'rest/mca-user/update-user',$scope.data.singleUser)
            .then(()=>{
                    $scope.actions.getAll()
                    $('#modal_user').modal('hide')
                    $.notify('Cập nhật người sử dụng thành công!','success')
                })
                .catch(error=>{
                    $scope.errors = error.data.errors
                    $.notify('Cập nhật người sử dụng thất bại!','error')
                })
                .finally(() => $rootScope.reloadPage = false)
        },
        deleteUser(id){
            $check = confirm('Bạn có muốn xóa đối tượng đã chọn?')
            if(!$check) return
            $http.delete(SITE_ROOT + 'rest/mca-user/delete-user/'+id)
            .then(()=>{
                $scope.actions.getAll()
                $.notify('Xóa người sử dụng thành công!','success')
            })
            .catch(()=>$.notify('Xóa người sử dụng thất bại!','error'))
        },
        getGroup(){
            $http.get(SITE_ROOT + 'rest/group')
            .then(response=>{
                $scope.data.listGroup = response.data.data
            })
        },
        changeGroup(){
            $scope.data.listGroup.forEach(item=>{
                if($scope.data.singleUser.user_role == item.group_code) item.checked =true
                else item.checked = false
            })
        },
        getProvince(){
            $http.get(SITE_ROOT + 'rest/province')
                .then(response => $scope.data.listProvince = response.data)
        },
        changeDistrict(){
            $http.get(SITE_ROOT + 'rest/district/get-by-province',{params:$scope.data.singleUser})
                .then(response => $scope.data.listDistrict = response.data)
        },
        changeVillage(){
            $http.get(SITE_ROOT + 'rest/village/get-by-district',{params:$scope.data.singleUser})
                .then(response => $scope.data.listVillage = response.data)
        },
        getType(){
            $http.get(SITE_ROOT + 'mca/type')
                .then(response => $scope.data.listType = response.data)
        },
        getSpec(){
            $http.get(SITE_ROOT + 'mca/spec')
                .then(response => $scope.data.listSpec = response.data)
        },

    };

    function getUserMeta(data=[]){
        let list_permit = []
        let list_group = []
        data.forEach(item => {
            if(item.user_meta_key == 'permit'){
                list_permit.push(item.user_meta_value)
                return
            }
            if(item.user_meta_key == 'GROUP_PARENT'){
                list_group.push(+item.user_meta_value)
                return
            }
            if(item.user_meta_value) $scope.data.singleUser[item.user_meta_key] = item.user_meta_value
        })
        $scope.data.listPermit.forEach(item=>{
            item.permit.forEach(item=>{
                if(list_permit.includes(item.code)) item.checked=true
                else item.checked=false
            })
        })
        $scope.data.listGroup.forEach(item=>{
            if(list_group.includes(item.group_id)) item.checked = true
            else item.checked = false
        })
    }

    function setPermitUser(){
        let list_permit = []
        $scope.data.listPermit.map(item=>item.permit).forEach(item=>{
            item.forEach(item=>{
                if (item.checked ===true) list_permit.push(item.code)
            })
        })
        $scope.data.singleUser.listPermit = list_permit
    }

    function getListGroupId(data=[]){
        return data.filter(item=>item.checked===true).map(item=>item.group_id)
    }

    function uploadUserAvatar(){
        const file_upload = new UploadFile('user_input_upload','user_button_upload','user_preview_image')

        file_upload.getInput().onchange = () => {
            file_upload.doUpload()
            .then(response=>{
                file_upload.previewUpload(response)
                $scope.data.singleUser.user_avatar = response[0].filepath
            })
        }
    }

    $scope.actions.initial();
});



