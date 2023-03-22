@extends('frontend.layout.app')
<style>
.modal-header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    background: #019341;
}

.modal-title {
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 700;
    font-size: 22px;
    line-height: 27px;
    color: #FFFFFF;
    text-align: center;
}

.modal-content {
    width: 770px;
}

.modal-body-custom {
    display: flex;
}

.modal-img {
    width: 25%;
}

.modal-img img {
    width: 159px;
    height: 120px;
    object-fit: cover;
}

.modal-text {
    width: 37%;
}

.modal-text p {
    margin-bottom: 11px;
    margin-top: 0px;
    font-family: 'Montserrat';
    font-style: normal;
    font-weight: 700;
    font-size: 13px;
    line-height: 16px;
    color: #000000;
}

.modal-text p span {

    color: #019341;
}

.description-text {
    border: 1px solid #000000;
    box-sizing: border-box;
    border-radius: 10px;
    padding: 10px;
    text-align: justify;
    min-height: 200px;
}

.modal-dialog {
    width: 770px;
}

.btn-custom {
    background-color: #019341;
}

.modal-footer {
    padding: 15px;
    text-align: center !important;
    border-top: 1px solid #e5e5e5;
}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 h-auto " style="padding-right: 20px;">
            <ul class="menu-left h100">
                <li><a href=""> <i class="fa fa-home" style="margin-right: 5px;"></i>Trang chủ</a></li>
                <li><a href="">Về chúng tôi</a></li>
                <li><a href="">Sản phẩm</a></li>
                <li><a href="">Hướng dẫn mua hàng</a></li>
                <li><a href="">liên hệ</a></li>
                <li><a href="">Hệ thống Showroom</a></li>
            </ul>
        </div>
        <div class="col-md-9 pdl0">
            <div id="carouselExampleCaptions" style="height: 450px;" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('apps/frontend/images/bn1.jpg')}}" class="d-block w-100 h-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Some representative placeholder content for the first slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('apps/frontend/images/bn2.jpg')}}" class="d-block w-100 h-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Second slide label</h5>
                            <p>Some representative placeholder content for the second slide.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{asset('apps/frontend/images/bn3.jpg')}}" class="d-block w-100 h-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Some representative placeholder content for the third slide.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <div class="row" style="padding-bottom: 40px;">
        <div class="col-md-12 h100">
            <div class="title-search">
                <p>Xu hướng tìm kiếm</p>
            </div>
            <div class="image-slider">
                @foreach($loaisanpham as $loai) <div class="image-item">
                    <div class="image">
                        <a href="{{asset('dochoi/list-product/'.$loai->id)}}"><img
                                src="{{asset($loai->media->filepath??'')}}" alt="" /></a>
                    </div>
                    <div class="img-title">
                        <h3 class="image-title">{{$loai->name}}</h3>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="banner-main">
                <img src="{{asset('apps/frontend/images/bannermain.jpg')}}" alt="" width="100%" height="100%">
            </div>
        </div>
    </div>
</div>
<div class="div-product pb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="elementor-heading-wrapper">
                    <span class="elementor-heading-dash-before"></span>
                    <h2 class="elementor-heading-title elementor-size-default">Sản phẩm mới</h2>
                    <span class="elementor-heading-dash-after"></span>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="container-grid">

                    @foreach($sanpham as $value)<div class="container-grid-product">
                        <div class="product-img">
                            <img src="{{asset($value->medias[0]->filepath??'')}}" alt="">
                            <div class="view-product">
                                <a href="{{asset('dochoi/product/'.$value->id)}}"> Xem sản phẩm</a>
                            </div>
                            <div class="add-to-cart">
                                <a href="{{asset('dochoi/product/'.$value->id)}}"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div class="product-name">
                            {{$value->name}}
                        </div>
                        <div class="rating-star">
                            <input type="hidden" class="rating" data-filled="mdi mdi-star text-primary"
                                data-empty="mdi mdi-star-outline text-primary" value="{{$value->quantity}}"
                                data-fractions="{{$value->quantity}}" />
                        </div>
                        <div class="product-price">
                            {{$value->price}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
@endpush