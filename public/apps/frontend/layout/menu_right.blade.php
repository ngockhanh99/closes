<?php
$list_article = $menu_right['list_article'];
$reflects = $menu_right['reflects'];
$questions = $menu_right['questions'];
$ocop_product = $menu_right['ocop_product'];
?>

<div class="thuvienanh" style="padding-top:20px">
    <div class="Tenmuc">
        <div class="thanhdoc"></div>
        <div class="text ">
            <a href="{{asset('ocop_product/nha-san-xuat')}}" target="_blank">
                Sản Phẩm OCOP
            </a>
        </div>
    </div>
    <div id="myCarousel_home" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner carousel-inner-home">
            @foreach($ocop_product as $key => $value)
            <div class="item {{$key == 0 ? 'active' : ''}}">
                <img src="{{asset($value->medias[0]->filepath??'')}}" alt="" style="width:100%;height:200px;object-fit: cover;">
                <div class="carousel-caption">
                    <a style="text-decoration:none" class="title-thuvien">{{$value -> name}}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="thuvienanh" style="padding-top:20px">
    <div class="Tenmuc">
        <div class="thanhdoc"></div>
        <div class="text ">
            <a href="{{asset('article/KHOA-HOC')}}  " target="_blank">
                Tin tức
            </a>
        </div>
    </div>
    <div id="myCarousel_home" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner carousel-inner-home">
            @foreach($list_article as $key => $value)
            <div class="item {{$key == 0 ? 'active' : ''}}">
                <img src="{{asset($value->medias[0]->filepath??'')}}" alt="" style="width:100%;height:200px;object-fit: cover;">
                <div class="carousel-caption">
                    <a href="{{$value->category!=''?asset('/article/'.$value->category->code.'/'.$value->id):''}}" class="title-thuvien">{{$value -> title}}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="thuvienanh" style="padding-top:20px">
    <div class="Tenmuc">
        <div class="thanhdoc"></div>
        <div class="text ">
            <a href="{{asset('questionAnswerExpert/tu-van-chuyen-gia')}}" target="_blank">
                Hỏi đáp chuyên gia
            </a>
        </div>
    </div>
    <div id="myCarousel_home" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner carousel-inner-home">
            @foreach($questions as $key => $value)
            <div class="item {{$key == 0 ? 'active' : ''}}">
                <img src="{{asset($value->medias[0]->filepath??'')}}" alt="" style="width:100%;height:200px;object-fit: cover;">
                <div class="carousel-caption">
                    <a href="{{asset('/questionAnswerExpertDetail/'.($value->type==1?'hoi-dap-chuyen-gia':'tu-van-chuyen-gia').'/'.$value->id)}}" class="title-thuvien">{{$value -> title}}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="thuvienanh" style="padding-top:20px">
    <div class="Tenmuc">
        <div class="thanhdoc"></div>
        <div class="text ">
            <a href="{{route('reflect')}}" target="_blank">
                Phản ánh kiến nghị
            </a>
        </div>
    </div>
    <div id="myCarousel_home" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner carousel-inner-home">
            @foreach($reflects as $key => $value)
            <div class="item {{$key == 0 ? 'active' : ''}}">
                <img src="{{asset($value->medias[0]->filepath??'')}}" alt="" style="width:100%;height:200px;object-fit: cover;">
                <div class="carousel-caption">
                    <a href="{{asset('/reflectDetail/'.$value->id)}}" class="title-thuvien">{{$value -> title}}</a>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
<div class="thuvienanh">
    <div class="Tenmuc">
        <div class="thanhdoc"></div>
        <div class="text lienket-a">
            <a>liên kết</a>
        </div>
    </div>
    <div style=" background-image: url('{{asset('apps/frontend/images') . '/banner_new.png' }}');
                                           background-repeat: no-repeat;
                                           background-size: 100% 100%;border-radius: 8px;">
        <a class="side-bar-lienket" href="http://hoinongdan.bacgiang.gov.vn/" target="_blank">

        </a>
    </div>
    <div style=" background-image: url('{{asset('apps/frontend/images') . '/dvcqg.png' }}');
                                           background-repeat: no-repeat;
                                           background-size: 100% 100%;border-radius: 8px;">
        <a class="side-bar-lienket" href="https://snnptnt.bacgiang.gov.vn/" target="_blank">
        </a>
    </div>
</div>