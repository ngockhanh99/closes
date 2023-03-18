app.directive('purchaseAskSent', function($http){
    return {
        restrict: 'E',
        scope: {
            loggedInUser: '=',
            targetId: '=',
            targetTable: '=',
            otherUserId: '=',
            id: '=',
        },
        templateUrl: 'apps/cores/views/directives/purchaseAsk/purchaseAskSent/purchaseAskSent.html',
        link: function(scope){
            scope.searchPurchaseAsk = ''
            scope.contentPurchaseAsk = ''
            scope.listFileIdPurchaseAsk = []
            scope.errors = {}
            scope.attachFile = new UploadFile('input_attach_sent_file', 'button_attach_sent_file', 'preview_attach_sent_file')
            scope.typeFileImage = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG']
            scope.methods = {}

            scope.methods = {
                getPurchaseAsk(){
                    $http.get(SITE_ROOT + 'mca/purchase-ask/list-sent', {params: {
                        target_id: scope.targetId,
                        target_table: scope.targetTable,
                        key_word: scope.searchPurchaseAsk,
                    }}).then(res => scope.listPurchaseAsk = res.data || [])
                },
                sendPurchaseAsk(){
                    if(scope.contentPurchaseAsk.trim() == '') {
                        scope.errors.contentPurchaseAsk = 'Bạn chưa nhập nội dung tin nhắn!'
                        return
                    }
                    $http.post(SITE_ROOT + 'mca/purchase-ask', {
                        other_user_id: scope.otherUserId,
                        content: scope.contentPurchaseAsk,
                        target_id: scope.targetId,
                        target_table: scope.targetTable,
                        list_file_id: scope.listFileIdPurchaseAsk,
                    })
                    .then(() => {
                        $.notify('Gửi tin nhắn thành công!', 'success')
                        $('#' + scope.id).modal('hide')
                    })
                    .catch(() => $.notify('Gửi tin nhắn thất bại!', 'error'))
                },
                seenPurchaseAsk(){
                    $http.put(SITE_ROOT + 'mca/purchase-ask/seen-purchase-ask', {
                        target_id: scope.targetId,
                        target_table: scope.targetTable,
                    })
                },
                attachFile(){
                    scope.attachFile.getInput().onchange = function(){
                        scope.attachFile.doUpload()
                            .then(res => {
                                scope.attachFile.emptyPreview()
                                for(let item of res) {
                                    if(scope.typeFileImage.includes(item.file_ext)) {
                                        scope.attachFile.getPreview().innerHTML += `<image style="margin:2px" width="160px" src="${item.filepath}" alt="${item.filename}"><br>`
                                    }
                                    else {
                                        scope.attachFile.getPreview().innerHTML += `<a href="${item.filepath}"><i class="bx bx-file"></i> ${item.filename}</a><br>`
                                    }
                                }
                                scope.listFileIdPurchaseAsk = res.map(item => item.id)
                            })
                    }
                },
            }

            scope.$watch('targetId', function(){
                scope.searchPurchaseAsk = ''
                scope.contentPurchaseAsk = ''
                scope.listFileIdPurchaseAsk = []
                scope.errors = {}
                scope.attachFile.emptyPreview()
                scope.methods.getPurchaseAsk()
                scope.methods.seenPurchaseAsk()
            })

            scope.methods.attachFile()

        }
    }
})
