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
    <div class="row" style="min-height: 500px;">
        <div class="col-md-12">
            <p style="font-size: 14px;"><i class="fa fa-home" style="margin-right: 5px;"></i> > Sản Phẩm > Loại sản phẩm
                > Tên sản phẩm</p>
        </div>
        <h1 id="empty-product" class="text-center" style="margin: 0;"> @if(count($order)==0)Không có sản phẩm @endif</h1>
        @if(count($order)>0)
        <div class="row" id="list-product"> 
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th colspan="2">Đơn giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order as $or)
                                    <tr>
                                        <td>
                                            <img src="{{asset($or->sanpham->medias[0]->filepath??'')}}" alt="product-img"
                                                title="product-img" class="avatar-md" />
                                        </td>
                                        <td>
                                            <h5 class="font-size-14 text-truncate"><a
                                                    href="ecommerce-product-detail.html" class="text-dark">{{$or->sanpham->name??''}}</a></h5>
                                            <p class="mb-0">Màu : <span class="fw-medium">{{$or->color->name??''}}</span>, Size : <span class="fw-medium">{{$or->size->name??''}}</span></p>
                                        </td>
                                        <td>
                                        {{$or->sanpham->price??''}}
                                        </td>
                                        <td>
                                            <div style="width: 120px;">
                                                <input type="text" value="{{$or->quantity??''}}" name="demo_vertical">
                                            </div>
                                        </td>
                                        <td>
                                        {{$or->sanpham->price*$or->quantity}}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="action-icon text-danger"> <i
                                                    class="mdi mdi-trash-can font-size-18"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <a href="ecommerce-products.html" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Tiếp tục mua sắm </a>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <button class="btn btn-success" onclick="cartPay()">
                                        <i class="mdi mdi-cart-arrow-right me-1"></i> Tiến hành đặt hàng</button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Card Details</h5>

                        <div class="card bg-primary text-white visa-card mb-0">
                            <div class="card-body">
                                <div>
                                    <i class="bx bxl-visa visa-pattern"></i>

                                    <div class="float-end">
                                        <i class="bx bxl-visa visa-logo display-3"></i>
                                    </div>

                                    <div>
                                        <i class="bx bx-chip h1 text-warning"></i>
                                    </div>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-4">
                                        <p>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                            <i class="fas fa-star-of-life m-1"></i>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <h5 class="text-white float-end mb-0">12/22</h5>
                                    <h5 class="text-white mb-0">Fredrick Taylor</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Order Summary</h4>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>Tổng cộng :</td>
                                        <td>{{$array_tt['sum']}} VND</td>
                                    </tr>
                                    <tr>
                                        <td>Giảm giá : </td>
                                        <td>{{$array_tt['discount']}}%</td>
                                    </tr>
                                    <tr>
                                        <td>Phí vận chuyển :</td>
                                        <td>{{$array_tt['ship']}} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Tổng Tiền :</th>
                                        <th>{{$array_tt['total']}} VND</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="cart-pay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Thông tin đặt hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="txt_name">Tên người nhận</label>
                        <input type="text" class="form-control" id="txt_name" name="name_reservie"
                            placeholder="Nhập tên" />
                </div>
                <div class="col-md-6">
                <label for="txt_name">Số điện thoại người nhận</label>
                        <input type="number" class="form-control" id="txt_name" name="phone_reservie"
                            placeholder="Nhập số điện thoại" />
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                <label for="txt_name">Tỉnh/thành phố</label>
                        <select name="province_id" id="province_id" class="form-control">
                            <option value="">--Chọn Tỉnh/thành phố--</option>
                            @foreach($province as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-6">
                <label for="txt_name">Quận/Huyện</label>
                        <select name="district_id" id="district_id" class="form-control">
                            <option value="">--Chọn Tỉnh/thành phố--</option>
                            @foreach($province as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                <label for="txt_name">Phường/Xã</label>
                        <select name="village_id" id="village_id" class="form-control">
                            <option value="">--Chọn Tỉnh/thành phố--</option>
                            @foreach($province as $pro)
                            <option value="{{$pro->id}}">{{$pro->name}}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-6">
                <label for="txt_name">Địa chỉ cụ thể</label>
                        <input type="text" class="form-control" id="txt_name" name="address_reservie"
                            placeholder="Nhập địa chỉ" />
                </div>
            </div>
            <input type="text" style="display:none ;" class="form-control" id="txt_name" name="payment" value='{{$array_tt['total']}}'/>

      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" onclick="payMent()" >Đặt hàng</button>
      </div>
    </div>
  </div>
</div>
@endsection