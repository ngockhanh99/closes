<div id="footer">
    <div class="container">
        <div class="row" style="padding:50px 0 30px 0;min-height:330px">
            <div class="col-md-3">
                <div class="container-info">
                    <div class="bar">
                        Về chúng tôi
                    </div>
                    <p class="ft-contact" style="margin-top: 20px;"> <img src="{{asset('apps/frontend/images/logo.png')}}" alt="" width="100px" height="100px"></p>
                    <p class="ft-contact">
                        - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapibus
                        lacus. Duis nec vestibulum magna, et dapibus lacus.
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="container-info">
                    <div class="bar">
                        Liên kết
                    </div>
                    <ul class="ul-footer">
                        <li><a href="">Về chúng tôi</a></li>
                        <li><a href="">Sản phẩm</a></li>
                        <li><a href="">Hướng dẫn mua hàng</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="container-info">
                    <div class="bar">
                        Thông tin
                    </div>
                </div>
                <div class="address" style=" margin-top: 20px;">
                    <p><b>- Địa chỉ: </b>{{$dashboard->address??''}}</p>
                </div>
                <div class="address">
                    <p><b>- Số điện thoại: </b>{{$dashboard->phone??''}}</p>
                </div>
                <div class="address">
                    <p><b>- Email: </b>{{$dashboard->email??''}}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="container-info">
                    <div class="bar">
                        Liên hệ 
                    </div>
                    <div class="button-container">
                        <div class="button" style="--color:#0b84ee">
                            <div class="dot"></div>
                            <div class="light"></div>
                            <button>
                            <a href="{{$dashboard->facebook??''}}" target="_blank" rel="noopener noreferrer">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                            </button>
                        </div>
                        <div class="button" style="--color:#2962ff">
                            <div class="dot"></div>
                            <div class="light"></div>
                            <button>
                                <a href="{{$dashboard->zalo??''}}" target="_blank" rel="noopener noreferrer">
                            <svg  class="zalo" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 48 48" width="28px" height="28px">
                                <path fill="#000" d="M15,36V6.827l-1.211-0.811C8.64,8.083,5,13.112,5,19v10c0,7.732,6.268,14,14,14h10	c4.722,0,8.883-2.348,11.417-5.931V36H15z"/>
                                <path fill="#eee" d="M29,5H19c-1.845,0-3.601,0.366-5.214,1.014C10.453,9.25,8,14.528,8,19	c0,6.771,0.936,10.735,3.712,14.607c0.216,0.301,0.357,0.653,0.376,1.022c0.043,0.835-0.129,2.365-1.634,3.742	c-0.162,0.148-0.059,0.419,0.16,0.428c0.942,0.041,2.843-0.014,4.797-0.877c0.557-0.246,1.191-0.203,1.729,0.083	C20.453,39.764,24.333,40,28,40c4.676,0,9.339-1.04,12.417-2.916C42.038,34.799,43,32.014,43,29V19C43,11.268,36.732,5,29,5z"/>
                                <path fill="#000" d="M36.75,27C34.683,27,33,25.317,33,23.25s1.683-3.75,3.75-3.75s3.75,1.683,3.75,3.75	S38.817,27,36.75,27z M36.75,21c-1.24,0-2.25,1.01-2.25,2.25s1.01,2.25,2.25,2.25S39,24.49,39,23.25S37.99,21,36.75,21z"/>
                                <path fill="#000" d="M31.5,27h-1c-0.276,0-0.5-0.224-0.5-0.5V18h1.5V27z"/>
                                <path fill="#000" d="M27,19.75v0.519c-0.629-0.476-1.403-0.769-2.25-0.769c-2.067,0-3.75,1.683-3.75,3.75	S22.683,27,24.75,27c0.847,0,1.621-0.293,2.25-0.769V26.5c0,0.276,0.224,0.5,0.5,0.5h1v-7.25H27z M24.75,25.5	c-1.24,0-2.25-1.01-2.25-2.25S23.51,21,24.75,21S27,22.01,27,23.25S25.99,25.5,24.75,25.5z"/>
                                <path fill="#000" d="M21.25,18h-8v1.5h5.321L13,26h0.026c-0.163,0.211-0.276,0.463-0.276,0.75V27h7.5	c0.276,0,0.5-0.224,0.5-0.5v-1h-5.321L21,19h-0.026c0.163-0.211,0.276-0.463,0.276-0.75V18z"/></svg>
                                </a>
                            </button>
                        </div>
                        <div class="button" style="--color:gray">
                            <div class="dot"></div>
                            <div class="light"></div>
                            <button>
                            <a href="{{$dashboard->instagram??''}}" target="_blank" rel="noopener noreferrer">
                                <ion-icon name="logo-instagram"></ion-icon>
                            </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div style="height: 70px; ">
            <p style="color:#fff; font-size: 14px;line-height: 70px;">
                Copyright © 2019 maianh.com Alright reversed.
            </p>
        </div>
    </div>
</div>