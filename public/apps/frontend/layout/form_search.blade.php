<form action="" method='GET'>
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <select class="form-control"name="listSpec_id" id="">
                    <option value=""> -- Tất cả lĩnh vực--</option>
                    @foreach($data['listSpec'] as $value)
                    <option value="{{$value->id}}" {{request('listSpec_id') == $value->id?'selected':''}}>{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group ">
                <input  class="form-control" type="text" placeholder="Nhập từ khóa..." value="{{ request('key_word') }}" name="key_word">
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-light btn-custom" type="submit"><i class="fa fa-search" style="color:#ffffff" aria-hidden="true"></i> Tìm kiếm</button>
        </div>
    </div>
</form>