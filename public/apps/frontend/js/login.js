let options = document.querySelectorAll('.changeType');
let form = document.getElementById('form');
let bgactive = document.getElementById('bg-active');
var rotatedeg = 0;



options.forEach(val => {
    val.addEventListener('click', function (event) {
        if (this.classList.contains('active')) {
            return;
        }
        form.classList.remove('login');
        form.classList.remove('register');
        form.classList.add(this.id);
        bgactive.style.left = this.offsetLeft + 'px';
        options.forEach(item => {
            item.classList.remove('active');
        });
        this.classList.add('active');

        rotatedeg = rotatedeg + 200;
        document.getElementById('rotate').style.transform = 'translate(-50%) rotate(' + rotatedeg + 'deg)';
    })
})
function validateForm() {
    var email = document.getElementById("email-reg").value;
    var password = document.getElementById("pass-reg").value;
    document.getElementById('error-email').innerHTML = ""
    document.getElementById('error-password').innerHTML = ""
    document.getElementById('error-email').style.margin = "0"
    document.getElementById('error-password').style.margin = "0"
    if (email == "") {
        document.getElementById('error-email').innerHTML = "Email không được để trống";
        document.getElementById('error-email').style.margin = "-20px 0 10px 0"
        return false;
    }
    if (password == "") {
        document.getElementById('error-password').textContent = "Mật khẩu không được để trống"
        document.getElementById('error-password').style.margin = "-20px 0 10px 0"
        return false;
    }
    if (password.length < 5) {
        document.getElementById('error-password').textContent = "Mật khẩu phải có ít nhất 5 ký tự"
        document.getElementById('error-password').style.margin = "-20px 0 10px 0"
        return false;
    }
    return true;
}
function cartPay(){
    $('#cart-pay').modal('show')
}