function UploadFile(upload_input,upload_button,preview_section){
    this.input = upload_input
    this.button = upload_button
    this.preview = preview_section

    let token = document.querySelector('meta[name=csrf-token]').getAttribute('content')
    const uploadInput = document.getElementById(this.input)
    const uploadButton = document.getElementById(this.button)
    const preview = document.getElementById(this.preview)

    if(uploadButton){
        uploadButton.onclick = () => uploadInput.click()
    }

    this.getInput = () => uploadInput
    this.getButton = () => uploadButton
    this.getPreview = () => preview
    this.doUpload = (url=SITE_ROOT+'rest/media/upload-file') => {
        let formData = new FormData()
        if(uploadInput.files.length == 0) return

        for(let item of uploadInput.files){
            formData.append('files[]',item)
        }

        return fetch(url,{
                method: 'POST',
                headers: {
                    "X-CSRF-Token": token,
                },
                body: formData,
            })
            .then(response => response.json())
    }
    this.deleteUpload = (url,id) => {
        return fetch(url + '/' + id,{
                method: 'DELETE',
                headers: {
                    "X-CSRF-Token": token,
                },
            })
            .then(response => response.json())
    }
    this.previewUpload = (data,type='image',width='190px',icon='') => {
        if(type=='image') preview.innerHTML = data.map(item=>`<image style="margin:2px" width="${width}" src="${item.filepath}" alt="${item.filename}">`).join('')
        if(type=='file') preview.innerHTML = data.map(item=>`<a href="${item.filepath}">${icon} ${item.filename}</a><br>`).join('')
    }
    this.emptyPreview = () => {
        preview.innerHTML = ''
    }
}

function handleDateTime(data){
    if(data === null || data == '1970-01-01') return null
    if(typeof data === 'string'){
        return new Date(data)
    }
    if(typeof data === 'object'){
        for(let item of data){
            if(item.begin_date !== null) item.begin_date = new Date(item.begin_date)
            if(item.end_date !== null) item.end_date = new Date(item.end_date)
        }
    }
}

function getUserRole(user_role=''){
    user_role = user_role || ''
    if(user_role == '') return {}
    let list_role = user_role.split(',')
    return list_role.reduce((result,current)=>{
        result[current] = true
        return result
    },{})
}

function getMetaByKey(key, meta_array = []){
    for(let item of meta_array){
        if(item.user_meta_key == key){
            return item.user_meta_value
        }
    }

}

function convertKeyObjectToNumber(data, listKey){
    for(let key of listKey){
        if(typeof data[key] != 'string') continue
        data[key] = +data[key].replace(/\D/g,'')
    }
}

function formatKeyObjectNumber(data, listKey){
    for(let key of listKey){
        if(typeof data[key] != 'number') continue
        data[key] = data[key].toLocaleString('en-US')
    }
}

function convertToNumber(data){
    if(typeof data != 'string') return data
    return data.replace(/\D/g,'')
}

function convertToNormalEnglishText(string){
    let str = string.toLowerCase();
    str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    str = str.replace(/[đĐ]/g, 'd');
    str = str.replace(/([^0-9a-z-\s])/g, '');
    str = str.replace(/^-+|-+$/g, '');
    return str;
}

function handleValueDatePicker(value = ''){
    if(!value) return
    return value.split('/').reverse().reduce((previous, current) => previous + '-' + current)
}
