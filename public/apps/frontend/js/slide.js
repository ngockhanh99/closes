$(document).ready(function () {
    $(".image-slider").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        draggable: false,
        prevArrow: `<button type='button' class='slick-prev slick-arrow'><ion-icon name="arrow-back-outline"></ion-icon></button>`,
        nextArrow: `<button type='button' class='slick-next slick-arrow'><ion-icon name="arrow-forward-outline"></ion-icon></button>`,
        dots: true,
        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    infinite: false,
                },
            },
        ],
        // autoplay: true,
        // autoplaySpeed: 1000,
    });

});
function addToCart(id) {
    if (USER_ID == '') {
        Swal.fire({
            title: 'Vui lòng đăng nhập để tiếp tục',
            cshowConfirmButton: false,
            icon: 'warning',
            timer: 1500
        });
        return
    }
    let size = document.querySelector('input[name=size]:checked')?.value;
    let color = document.querySelector('.color-choose.active')?.getAttribute('data-color');
    let quantity = document.querySelector('input[name=quantity]')?.value;
    let data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        san_pham_id: id,
        size_id: size,
        color_id: color,
        quantity: quantity
    }
    $.post(SITE_ROOT + 'dochoi/add-to-cart', data, function () {
        Swal.fire({
            title: 'Thêm sản phẩm thành công',
            cshowConfirmButton: false,
            icon: 'success',
            timer: 1500
        });
    })
}
function activeColor() {
    let color = document.querySelectorAll('.color-choose');
    color.forEach(item => {
        item.onclick = function () {
            color.forEach(ele => {
                ele.classList.remove('active')
            })
            item.classList.add('active')
        }
    })
    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 39) {
            $(".main-header").addClass('fixed-top');
        } else {
            $(".main-header").removeClass('fixed-top');
        }
    });
    const input = document.getElementById('search-home');
    console.log(input)
    const placeholder = input.getAttribute('placeholder');
    let index = 0;

    setInterval(() => {
        if (index === placeholder.length) {
            index = 0;
        }
        if (input.value.length === 0) {
            input.setAttribute('placeholder', placeholder.slice(0, index + 1));
        }
        index++;
    }, 170);
}
function cartPay() {
    $('#cart-pay').modal('show')
    document.querySelector('input[name=name_reservie]').value = "";
    document.querySelector('input[name=phone_reservie]').value = "";
    document.getElementById('province_id').value = "";
    document.getElementById('district_id').value = "";
    document.getElementById('village_id').value = "";
    document.querySelector('input[name=address_reservie]').value = "";
}
function payMent() {
    let name = document.querySelector('input[name=name_reservie]').value;
    let phone = document.querySelector('input[name=phone_reservie]').value;
    let province_id = document.getElementById('province_id').value;
    let district_id = document.getElementById('district_id').value;
    let village_id = document.getElementById('village_id').value;
    let address_reservie = document.querySelector('input[name=address_reservie]').value;
    let payment = document.querySelector('input[name=payment]').value;
    let data = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        name: name,
        phone: phone,
        province_id: province_id,
        district_id: district_id,
        village_id: village_id,
        address_reservie: address_reservie,
        payment: payment,
    }
    $.post(SITE_ROOT + 'dochoi/order', data, function () {
        $('#list-product').html('')
        $('#empty-product').html('Không có sản phẩm')
        $('#empty-product').css('margin', '20px')
        $('#cart-pay').modal('hide')

    })
}
activeColor()
