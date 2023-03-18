$(document).ready(function () {
    $('.grid-right-view').click(function () {
        var id = $(this).attr('id');
        var name = $(this).data('name');
        var site_root = $(this).data('site-root');
        var url = $(this).data('url');
        var url_detail = $(this).data('url-detail');
        if (name == 'nha-san-xuat') {
            user_name = "Nhà sản xuất"
        } else if (name = 'nha-thuong-mai') {
            user_name = "Nhà thương mại"
        }
        if (url == 'home') {
            url_name = 'commercial_connection/';
        } else {
            url_name = '';
        }
        var formatDate = function (data) {
            var date = new Date(data);
            day = date.getDate();
            month = date.getMonth() + 1;
            if (String(day).length == 1)
                day = '0' + day;
            if (String(month).length == 1)
                month = '0' + month;
            return day + '-' + month + '-' + date.getFullYear();
        };
        function isset(accessor) {
            try {
                return accessor() !== undefined && accessor() !== null
            } catch (e) {
                return false
            }
        }
        function getData(value) {
            if(value==null){
                return 0
            }else{
                return value.toLocaleString('en-US');
            }
        }
        $.ajax({
            url: url_name + name + "/"+url_detail,
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                name: name,
            },
            success: function (data) {
                $('#exampleModalCenter').modal('show');
                document.getElementById('exampleModalCenterTitle').innerHTML = user_name + ': <span class="user_name_modal">' + data.user.user_name + '</span></h5>'
                if (name == "nha-san-xuat") {
                    html_left = '<p>Tên sản phẩm: <span>' + data.name + '</span></p>'
                        + '<p>Mã sản phẩm: <span>' + data.code + ' </span></p>'
                        + '<p>Giá bán đầu bờ: <span>' + data.price.toLocaleString('en-US') + ' đ' + '</span></p>'
                        + '<p>Giá bán sơ chế: <span>' + data.price_processed.toLocaleString('en-US') + ' đ' + '</span></p>'
                        + '<p>Địa chỉ email: <span>' + data.user.user_email + '</span></p>';
                    html_right = '<p>Ngày sản xuất: <span>' + formatDate(data.manufacture_process.issued_date) + '</span></p>'
                        + '<p>Tiêu chuẩn: <span>' +(typeof data.manufacture_process.standard_info=='undefined'?'':data.manufacture_process.standard_info.name) + ' </span></p>'
                        + '<p>Sản lượng: <span>' +getData(data.procedure.quantity)+ ' ' + data.unit.name + ' </span></p>'
                        + '<p>Đã bán: <span>' + (parseInt(data.quantity) + parseInt(data.quantity_processed)).toLocaleString('en-US') + ' ' + data.unit.name + '</span><p>'
                        + '<p>Số điện thoại: <span> ' + data.user.user_phone + '</span></p>';
                } else {
                    html_left = '<p>Tên sản phẩm: <span>' + data.name + '</span></p>'
                        + '<p>Mã đơn: <span>' + data.code + ' </span></p>'
                        + '<p>Giá nhập: <span>' + data.price.toLocaleString('en-US') + ' đ' + '</span></p>'
                        + '<p>Trạng thái: <span>' + (data.status == 1 ? 'Còn hạn' : 'Hết hạn') + '</span></p>'
                        + '<p>Địa chỉ email: <span>' + data.user.user_email + '</span></p>';
                    html_right = '<p>Ngày nhập: <span>' + formatDate(data.date_needed) + '</span></p>'
                        + '<p>Tiêu chuẩn: <span>' + data.standard_info.name + '</span></p>'
                        + '<p>Cần nhập: <span>' + data.amount.toLocaleString('en-US') + ' ' + ((isset(() => data.type_product.unit.name)) ? data.type_product.unit.name : '') + '</span></p>'
                        + '<p>Đã nhập: <span>' + getData(data.quantity_needed)+ ' ' + ((isset(() => data.type_product.unit.name)) ? data.type_product.unit.name : '') + '</span>'
                        + '<p>Số điện thoại: <span>' + data.user.user_phone + '</span></p>';
                }
                document.getElementById('modal-text-left').innerHTML = html_left;
                document.getElementById('modal-text-right').innerHTML = html_right;
                document.getElementById('description-text').innerHTML = data.description;
                $("#img-src").attr("src", site_root + data.medias[0].filepath);
            }
        })
    })
    $('.text-3-line').click(function () {
        $(this).toggleClass('display-block');
    })
    var specifiedElement = document.getElementById('info-user-section');
    document.addEventListener('click', function (event) {
        var isClickInside = specifiedElement.contains(event.target);
        if (isClickInside) {
            $(".dropdown-menuUser").toggleClass('height-auto');
        }
        else {
            $(".dropdown-menuUser").removeClass('height-auto');
        }
    });
});
window.onscroll = function () { myFunction() };

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}