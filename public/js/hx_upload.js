var HxUploadFiles = {
    serverUpload: 'rest/media/upload',
    arr_http: [],
    tagsUpload: 'myFile',
    tagsProgress: 'progress-group',
    doUpload: function (resolve, reject) {
        document.getElementById(this.tagsProgress).inerHTML = '';
        var files = document.getElementById(this.tagsUpload).files;
        if (files.length == 0) {
            reject(false);
        }
        var $this = this;
        var resp = {
            'data': [],
            'error': []
        };
        var files_length = files.length;
        var upload_done = 0;
        for (var i = 0; i < files_length; i++) {
            new Promise((resolveChild, rejectChild) => {
                $this.uploadFile(files[i], i, resolveChild, rejectChild);
            }).then(function (success) {
                upload_done++;
                resp.data.push(success);
                if (upload_done == files_length) {
                    if (resp.data.length = files_length) {
                        resolve(resp);
                    } else {
                        reject(resp);
                    }
                }
            }, function error(error) {
                upload_done++;
                resp.error.push(error);
                if (upload_done == files_length) {
                    reject(resp);
                }
            });
        }
    },
    uploadFile: function (file, index, resolve, reject) {
        var http = new XMLHttpRequest();
        this.arr_http.push(http);
        /**
         * Khởi tạo vùng tiến trình
         * @type Element Div#progress-group
         */
        var progressGroup = document.getElementById(this.tagsProgress);
        //Div.progress
        var progress = document.createElement('div');
        progress.className = 'progress';
        //div.progress-bar
        var progressBar = document.createElement('div');
        progressBar.className = 'progress-bar';

        progress.appendChild(progressBar);
        progressGroup.appendChild(progress);
        http.upload.addEventListener('progress', function (event) {
            var fileName = file.name;
            var fileLoaded = event.loaded;
            var fileTotal = event.total;
            var fileProgress = parseInt((fileLoaded / fileTotal) * 100) || 0;
            progressBar.innerHTML = fileName + ' đang được upload ...';
            progressBar.style.width = fileProgress + '%';

            if (fileProgress == 100) {
                progressBar.innerHTML = fileName + ' upload done';
            }
        }, false);

        //start upload
        var data = new FormData();
        data.append('fileName', file.name);
        data.append('myfile', file);
        http.open('post', this.serverUpload, true);
        http.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        http.send(data);
        //Nhận dữ liệu trả về
        http.onreadystatechange = function (event) {
            //Kiểm tra điều kiện
            if (http.readyState == 4 && http.status == 200) {
                try {
                    var server = JSON.parse(http.response);
                    if (server.filename) {
                        progressBar.className = 'progress-bar-success';
                    } else {
                        progressBar.className = 'progress-bar-danger';
                    }

                    progressBar.innerHTML = 'Tải tài liệu [' + server.filename + '] thành công.';
                    resolve(server);
                } catch (e) {
                    reject(e);
                    progressBar.className = 'progress-bar-danger';
                    progressBar.innerHTML = 'Tải tập tin [' + file.name + '] thất bại';

                }
            } else if (http.status != 200) {
                try {
                    var server = JSON.parse(http.response);
                    progressBar.innerHTML = 'Tải tập tin [' + file.name + '] thất bại: ' + server.msgError;
                } catch (e) {
                    progressBar.className = 'progress-bar-danger';
                    progressBar.innerHTML = 'Tải tập tin [' + file.name + '] thất bại';
                }

                reject(http);
            }
            http.removeEventListener('progress', function () {
            });//Giải phóng bộ nhớ
        }
    },
    cancleUpload: function () {
        for (var i = 0; i < this.arr_http.length; i++) {
            this.arr_http[i].removeEventListener('progress', function () {
            });//Bỏ sự kiến
            this.arr_http[i].abort();
        }
        var progressBar = document.getElementsByClassName('progress-bar');
        for (var i = 0; i < progressBar.length; i++) {
            progressBar[i].className = 'progress progress-bar progress-bar-danger';
        }
    }
};
