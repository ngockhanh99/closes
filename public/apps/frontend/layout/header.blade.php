<header class="main-header">
    <div class="container">
        <div class="div-main-header">
            <p><i class="fa fa-facebook-square" aria-hidden="true"></i> | <i class="fa fa-instagram" aria-hidden="true"></i></p>
            <div class="div-main-header-login">
                <div class="login_fe">
                    @if(!Auth::user())
                    <a href="{{asset('home/login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>Đăng nhập</a>
                    @else
                    <div class="img-user">{{mb_substr(Auth::user()->user_name, 0, 1);}}</div>
                    @endif
                </div>
                <div class="hekp_fe">
                    <i class="fa fa-question-circle" aria-hidden="true"></i> Hướng dẫn mua hàng
                </div>
            </div>
        </div>
    </div>
</header>
<div class="menu-header">
    <div class="container h100">
        <div class="div-menu-header h100">
            <div class="logo text-center">
                <img src="{{asset('apps/frontend/images/logo.png')}}" alt="" width="100px" height="70px">
            </div>
            <div class="search">
                <form action="">
                    <input type="text" class="form-control" placeholder="Nhập từ khóa..">
                </form>
            </div>
            <div class="shopping-card text-center">
                <a href="{{route('cart')}}"><i class="fa fa-cart-plus" aria-hidden="true" data-count={{count($order)}}></i></a>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row margin0">
    <div class="container h100">
        <div class="div-menu-top">
            <ul class="div-menu-ul">
                <li><a href=""> <i class="fa fa-home" style="margin-right: 5px;"></i>Trang chủ</a></li>
                <li><a href="">Về chúng tôi</a></li>
                <li><a href="">Sản phẩm</a></li>
                <li><a href="">Hướng dẫn mua hàng</a></li>
                <li><a href="">liên hệ</a></li>
                <li><a href="">Hệ thống Showroom</a></li>
            </ul>
        </div>
    </div>
</div> -->