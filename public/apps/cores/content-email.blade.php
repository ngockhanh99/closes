<div class="content-email">
    <div class="title-section">
        <label class="title">MCA Bắc Giang</label>
        <div class="sub-title">Gửi mã xác thực tài khoản</div>
    </div>
    <div class="code-section">
        <p>Sau khi nhập mã xác thực, bạn có thể đặt lại mật khẩu của mình.</p>
        <label>Mã xác thực của bạn là:&ensp;</label><span class="code">{{$code}}</span>
    </div>
    <div class="note"><b>MCA Bắc Giang</b> xin trân trọng cảm ơn!</div>
</div>

<style>
.content-email {
    font-size: 15px;
    text-align: center;
}
.title-section {
    border-bottom: 1px solid #d12323;
    padding:10px;
}
.content-email .title {
    font-size:18px;
    font-weight: bold;
    text-transform: uppercase;
}
.sub-title {
}
.code-section {
    margin:10px 0px;
}
.code {
    color:red;
    font-size:18px;
    background-color: lightblue;
    padding:7px;
    border-radius:5px;
}
.note {
    font-style: italic;
}
</style>