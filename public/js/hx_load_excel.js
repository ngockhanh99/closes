var HxLoadFileExcel = {
    serverUpload: 'rest/excel/loadContent',
    arr_http: [],
    tagsUpload: 'myFile',
    typeUpload: '',
    doUpload: function (resolve, reject) {
        var files = document.getElementById(this.tagsUpload).files;
        if (files.length == 0) {
            reject(false);
        }
        var $this = this;
        new Promise((resolveChild, rejectChild) => {
            $this.uploadFile(files[0], 0, resolveChild, rejectChild);
        }).then(function (success) {
            resolve(success);
        }, function error(error) {
            reject(error);
        });
    },
    uploadFile: function (file, index, resolve, reject) {
        var http = new XMLHttpRequest();
        this.arr_http.push(http);
        //start upload
        var data = new FormData();
        data.append('fileName', file.name);
        data.append('myfile', file);
        data.append('type', this.typeUpload);
        http.open('post', this.serverUpload, true);
        http.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        http.send(data);
        //Nhận dữ liệu trả về
        http.onreadystatechange = function (event) {
            //Kiểm tra điều kiện
            if (http.readyState == 4 && http.status == 200) {
                try {
                    var server = JSON.parse(http.response);
                    resolve(server);
                } catch (e) {
                    reject(e);
                }
            } else if (http.status != 200) {
                reject(http);
            }
        }
    },
};
