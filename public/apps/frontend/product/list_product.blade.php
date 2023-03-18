@extends('frontend.layout.app')
@push('css')
<link rel="stylesheet" href="{{asset('apps/frontend/css/article.css')}}">
<link rel="stylesheet" href="{{asset('apps/frontend/css/menu_detail_page.css')}}">
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
<div class="container mb-5">
    <div class="row">
        <div class="col-md-12 mt-3">
            <p style="font-size: 14px;"><i class="fa fa-home" style="margin-right: 5px;"></i> > Loại sản phẩm</p>
        </div>
        <div class="col-md-3 h-auto " style="padding-right: 20px;">
            <ul class="menu-left h100">
                <li><a href="">Danh mục</a></li>
                @foreach($listloaisanpham as $li)
                <li><a href="{{asset('dochoi/list-product/'.$li->id)}}">{{$li->name??''}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9">
            <div class="banner-product">
                <img src="{{asset('apps/frontend/images/shop1_shop_slider1.jpg')}}" alt="" width="100%" height="100%"
                    style="object-fit: cover;">
            </div>
            <div class="row mt-4">
            <div class="col-md-2">Tìm kiếm:</div>
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nhập tên sản phẩm.."></div>
            </div>
            <div class="mt-3">
                <div class="container-grid-list">
                    @foreach($listsanpham as $key => $sp) <div class="container-grid-product">
                        <div class="product-img">
                            <img src="{{asset($sp->medias[0]->filepath??'')}}" alt="">
                            <div class="view-product">
                                <a href="{{asset('dochoi/product/'.$sp->id)}}"> Xem sản phẩm</a>
                            </div>
                            <div class="add-to-cart">
                                <a href="{{asset('dochoi/product/'.$sp->id)}}"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="product-name">
                            {{$sp->name??''}}
                        </div>
                        <div class="rating-star">
                            <input type="hidden" class="rating" data-filled="mdi mdi-star text-primary"
                                data-empty="mdi mdi-star-outline text-primary" data-fractions="2"
                                value="{{$sp->quantity??''}}" />
                        </div>
                        <div class="product-price">
                            {{$sp->price??''}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection