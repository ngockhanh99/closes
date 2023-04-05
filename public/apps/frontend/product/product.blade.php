@extends('frontend.layout.app')
@push('css')
@endpush
@section('content')
<div class="row margin0">
    <div class="menu-top">
        <div class="container h100 padding0">
            <ul class="div-menu-ul">
            <li><a href="{{asset('')}}"> <i class="fa fa-home" style="margin-right: 5px;"></i>Trang chủ</a></li>
                <li><a href="">Về chúng tôi</a></li>
                <li><a href="{{asset('dochoi/list-product/'.$listloaisanpham[0]->id)}}">Sản phẩm</a></li>
                <li><a href="">Hướng dẫn mua hàng</a></li>
                <li><a href="">Liên hệ</a></li>
            </ul>
        </div>
    </div>

</div>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <p style="font-size: 14px;"><i class="fa fa-home" style="margin-right: 5px;"></i>
                >{{$sanpham->loaisanpham->danhmuc->name??'Sản phẩm'}} >
                {{$sanpham->loaisanpham->name??''}}
                > {{$sanpham->name??""}}</p>
        </div>
        <div class="col-xl-6">
            <div class="product-detai-imgs">
                <div class="row">
                    <div class="col-md-2 col-sm-3 col-4">
                        <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach($sanpham->medias as $key=> $media) <a class="nav-link {{$key==0?'active':''}}"
                                id="product-{{$key+1}}-tab" data-bs-toggle="pill" href="#product-{{$key+1}}" role="tab"
                                aria-controls="product-{{$key+1}}" aria-selected="true">
                                <img src="{{asset($media->filepath??'')}}" alt=""
                                    class="img-fluid mx-auto d-block rounded">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            @foreach($sanpham->medias as $key=> $media) <div
                                class="tab-pane fade {{$key==0?'show active':''}}" id="product-{{$key+1}}"
                                role="tabpanel" aria-labelledby="product-{{$key+1}}-tab">
                                <div class="div-img-product">
                                    <img src="{{asset($media->filepath??'')}}" alt="" width="100%"
                                        class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <button type="button" id="add-product" onclick="addToCart({{$sanpham->id}})"
                                class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                <i class="bx bx-cart me-2"></i> Thêm sản phẩm
                            </button>
                            <button type="button" class="btn btn-success waves-effect  mt-2 waves-light">
                                <i class="bx bx-shopping-bag me-2"></i> Mua ngay
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="mt-4 mt-xl-3">
                <a href="javascript: void(0);" class="text-primary">{{$sanpham->loaisanpham->name??''}}</a>
                <h4 class="mt-1 mb-3">{{$sanpham->name??""}}</h4>

                <p class="text-muted float-start me-3">
                    @for($star = 0;$star <= 4;$star++) <span
                        class="bx bxs-star {{$star<$sanpham->quantity?'text-warning':''}}"></span>
                        @endfor
                </p>
                <p class="text-muted mb-4">( 152 Review )</p>

                <!-- <h6 class="text-success text-uppercase">20 % Off</h6> -->
                <h5 class="mb-4">Giá : <span class="text-muted me-2"><del>$240 USD</del></span>
                    <b>{{ number_format($sanpham->price, 0, '.', ',')." ₫"}}</b>
                </h5>
                <p class="text-muted mb-4">{!! html_entity_decode($sanpham->description??'') !!}</p>
                @if(count($size)>0)
                <div class="product-size">
                    <h5 class="font-size-15">Size :</h5>
                    <div class="size-input"> @foreach($size as $key => $s) <input type="radio" class="input-size" name="size" value="{{$s->id}}"
                        id="radio-{{$key}}" {{$key==0?'checked':''}}><label for="radio-{{$key}}" data-checkbox="{{$s->name}}"
                        class="label-size"></label>
                    @endforeach</div>
                   
                </div>
                @endif
                <div class="product-size">
                <h5 class="font-size-15">Số lượng :</h5>
                <input class="form-control" id='product-quantity' type="number" min="1" step="1" name="quantity" value="1">
                </div>
                @if(count($color)>0)
                <div class="product-color">
                    <h5 class="font-size-15">Màu :</h5>
                    @foreach($color as $key => $c)
                    <a href="javascript: void(0);" class="color-choose {{$key==0?'active':''}}" data-color="{{$c->id}}">
                        <div class="product-color-item border">
                            <img src="{{asset($c->media->filepath??'')}}" alt="" class="avatar-md">
                        </div>
                        <p>{{$c->name??''}}</p>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <h1>Mô Tả sản phẩm</h1>
            <div style="font-size: 14px;">
                {!! html_entity_decode($sanpham->description??'') !!}
            </div>
        </div>
        <div class="col-md-12 mt-5 mb-5 h100">
            <div class="title-search">
                <p>Sản phẩm liên quan</p>
            </div>
            <div class="image-slider">
                @foreach($listsanpham as $sp) <div class="image-item">
                    <div class="image">
                        <img src="{{asset($sp->medias[0]->filepath??'')}}" alt="" />
                    </div>
                    <div class="img-title">
                        <h3 class="image-title">{{$sp->name??''}}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection