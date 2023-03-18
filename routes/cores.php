<?php
Route::prefix('admin')->group(function () {

//Views
    Route::get('/', 'Controller@index')->name('defaultPageAfterLogin')->middleware(['web', 'auth']);
    Route::get('/chinh-sach-bao-mat', 'Controller@privacyPolicy');
    Route::get('/login', 'LoginCtrl@index')->name('login')->middleware('guest');


//Quên mật khẩu
    Route::get('/resetPassword', 'ResetPasswordController@resetPassword');
    Route::get('/authTwoStepVerification', 'ResetPasswordController@authTwoStepVerification');
    Route::post('/resetPassword', 'ResetPasswordController@sendMail');
    Route::get('/checkVerification', 'ResetPasswordController@checkVerification');
    Route::post('/changePassword', 'ResetPasswordController@changePassword');

    Route::get('/checkDistance', 'Sipas\SipasEvaluationRoundCtrl@checkDistance');

    Route::get('/auth/facebook', 'Auth\FacebookController@redirectToFacebook');
    Route::get('/auth/facebook/callback', 'Auth\FacebookController@handleFacebookCallback');
    Route::get('/auth/google', 'Auth\GoogleController@redirectToGoogle');
    Route::get('/auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

//Register
    Route::prefix('register')->group(function () {
        Route::get('/', 'MCARegisterController@index')->name('register.index')->middleware('guest');
        Route::post('/insert', 'MCARegisterController@insert')->name('register.insert')->middleware('guest');
        Route::post('/verify-email', 'MCARegisterController@verifyEmail')->name('register.verifyEmail')->middleware('guest');
    });

//Reset Password
    Route::prefix('reset-password')->group(function () {
        Route::get('/', 'MCAResetPasswordController@index')->name('reset-password.index')->middleware('guest');
        Route::get('/reset-code', 'MCAResetPasswordController@sendEmail')->name('reset-password.sendEmail')->middleware('guest');
        Route::post('/reset-password', 'MCAResetPasswordController@resetPassword')->name('reset-password.resetPassword')->middleware('guest');
        Route::post('/verify-reset-code', 'MCAResetPasswordController@changePasswordAfterVerify')->name('reset-password.verifyResetCode')->middleware('guest');
    });

//Auth::routes();
//Auth
    Route::prefix('auth')->group(function () {
        Route::post('login', 'LoginCtrl@login')->name('Đăng nhập hệ thống');
        Route::get('logout', 'LoginCtrl@logout')->name('Đăng xuất');
        #đăng ký
        Route::get('/register', 'RegisterController@index');
        Route::get('/register/twoStep', 'RegisterController@twoStep');
        Route::get('/register/done', 'RegisterController@done');
        Route::post('/district', 'RegisterController@district')->name('district');
        Route::post('/villages', 'RegisterController@villages')->name('villages');
        Route::post('/registerSendMail', 'RegisterController@registerSendMail');
        Route::post('/register', 'RegisterController@register');

    });

    Route::get('/chat', 'ChatsController@index');
    Route::get('/notifi', 'ChatsController@notifi');
    Route::get('/messages', 'ChatsController@fetchMessages');
    Route::post('/messages', 'ChatsController@sendMessage');

    Route::get('test', function () {
        event(new App\Events\StatusLiked('Someone'));
        return "Event has been sent!";
    });
});

Route::prefix('rest')->group(function () {

    Route::prefix('menu')->group(function () {
        #lấy danh sách menu
        Route::get('/', 'Cores\Rest\MenuCtrl@store');
    });

    Route::prefix('permit')->group(function () {
        #Lấy danh quyền
        Route::get('/', 'Cores\Rest\PermitCtrl@getAll');
    });


    Route::prefix('config')->group(function () {
        Route::get('/system', 'Cores\Rest\SipasConfigCtrl@getAll');


    });

    Route::prefix('chat-realtime')->group(function () {
        Route::get('/get-messages/{id}', 'Cores\Rest\ChatRealtimeCtrl@getMessageByChatId');
        Route::post('/update-status', 'Cores\Rest\ChatRealtimeCtrl@updateStatus');
        Route::get('/get-chat', 'Cores\Rest\ChatRealtimeCtrl@getChatByUserId');
        Route::get('/{id}', 'Cores\Rest\ChatRealtimeCtrl@getDataByUser');
    });

    Route::prefix('ou')->group(function () {
        #Lấy danh sách đơn vị
        Route::get('/', 'Cores\Rest\OuCtrl@getAll');
        #Lấy danh sách đơn vị nhận thông báo
        Route::get('/receivedNotificationOu', 'Cores\Rest\OuCtrl@receivedNotificationOu');
        Route::get('/nested', 'Cores\Rest\OuCtrl@getAllNested');
        #Lấy danh sách đơn vị cho đợt đánh giá
        Route::get('/forEvaluationRound', 'Cores\Rest\OuCtrl@getAllOuForEvaluationRound');
        #Lay danh sach don v & nguoi su dung
        Route::get('/allOuAndUser/{id_parent}', 'Cores\Rest\OuCtrl@getAllOuAndUser');
        #Lay danh sach don vi & don vi khao sat
        Route::get('/allOuAndOuSurvey/{ou_id}', 'Cores\Rest\OuCtrl@getAllOuAndOuSurvey');
        #Lay danh sach phong ban
        Route::get('/getDepartment/{id_parent}', 'Cores\Rest\OuCtrl@getDepartment');
        #Lấy thông tin chi tiết một đơn vị
        Route::get('/{id}', 'Cores\Rest\OuCtrl@getSingle');
        #Thêm mới đơn vị
        Route::post('/', 'Cores\Rest\OuCtrl@insert');
        #Sửa thông tin đơn vị
        Route::put('/{id}', 'Cores\Rest\OuCtrl@edit');
        #Xóa đơn vị
        Route::delete('/{id}', 'Cores\Rest\OuCtrl@destroy');
    });
    Route::prefix('options')->group(function () {
        Route::get('/', 'Cores\Rest\OptionsCtrl@getAll');
        Route::post('/', 'Cores\Rest\OptionsCtrl@update')->middleware('role:config-system');
    });
    Route::prefix('group')->group(function () {
        #Lấy danh sách nhóm NSD
        Route::get('/', 'Cores\Rest\GroupCtrl@getAll')->name('group.getAll');
        #Lấy thông tin chi tiết một nhóm người sử dụng
        Route::get('/{id}', 'Cores\Rest\GroupCtrl@getSingle');
        #Thêm mới nhóm người sử dụng
        Route::post('/', 'Cores\Rest\GroupCtrl@insert')->middleware('role:group');
        #Sửa thông tin nhóm người sử dụng
        Route::put('/{id}', 'Cores\Rest\GroupCtrl@edit')->middleware('role:group');
        #Xóa nhóm NSD
        Route::delete('/{id}', 'Cores\Rest\GroupCtrl@destroy')->middleware('role:group');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/get-hightlight-article', 'Cores\Rest\DashboardCtrl@getHightlightArticle');
        Route::get('/get-category', 'Cores\Rest\DashboardCtrl@getCategory');
        Route::get('/get-single-article/{id}', 'Cores\Rest\DashboardCtrl@getSingleArticle');
        Route::get('/get-article-by-category/{id}', 'Cores\Rest\DashboardCtrl@getArticleByCategory');
    });

    Route::prefix('user')->group(function () {
        #Lấy danh sách đơn vị
        Route::get('/', 'Cores\Rest\UserCtrl@getAll');
        #Lấy danh sách phòng ban cán bộ có quyền tu danh gia
        Route::get('/getAllAssignment/{ou_id}', 'Cores\Rest\UserCtrl@getAllAssignment');
        #Lấy danh sách phòng ban cán bộ có quyền thẩm định
        Route::get('/getUserAssign', 'Cores\Rest\UserCtrl@getAllAssign');
        Route::get('/getAllAssignCheck', 'Cores\Rest\UserCtrl@getAllAssignCheck');
        #Lấy danh sách người sử dụng
        Route::get('/listUser', 'Cores\Rest\UserCtrl@getListUser');
        #Lấy danh sách phòng ban cán bộ có quyền khảo sát xhh
        Route::get('/getUserXHH', 'Cores\Rest\UserCtrl@getUserXHH');
        #Lấy thông tin người sử dụng đã đăng nhập
        Route::get('/getUser', 'Cores\Rest\UserCtrl@getUser');
        #Lấy thông tin chi tiét một người sử dụng
        Route::get('/{id}', 'Cores\Rest\UserCtrl@getSingle');
        #Kiểm tra quyền
        Route::get('/permission/{role}', 'Cores\Rest\UserCtrl@permission');
        #Thêm mới người sử dụng
        Route::post('/', 'Cores\Rest\UserCtrl@insert')->middleware('role:user');
        //reset password
        Route::put('/reset', 'Cores\Rest\UserCtrl@resetPassword')->middleware('role:user');
        #Sửa thông tin người sử dụng
        Route::put('/{id}', 'Cores\Rest\UserCtrl@update')->middleware('role:user');
        #Xóa người dùng
        Route::delete('/{id}', 'Cores\Rest\UserCtrl@destroy')->middleware('role:user');
        #Thay đổi mật khẩu
        Route::put('/{id}/changePassword', 'Cores\Rest\UserCtrl@changePassword')->where('id', '[0-9]+');
    });

    Route::prefix('mca-user')->group(function () {
        Route::get('/list-user', 'Cores\Rest\MCAUserCtrl@getListUser')->middleware('role:user');
        Route::get('/get-user-by-email', 'Cores\Rest\MCAUserCtrl@getUserByEmail');
        Route::post('/insert-user', 'Cores\Rest\MCAUserCtrl@insertUser')->middleware('role:user');
        Route::put('/update-user', 'Cores\Rest\MCAUserCtrl@updateUser')->middleware('role:user');
        Route::delete('/delete-user/{id}', 'Cores\Rest\MCAUserCtrl@deleteUser')->middleware('role:user');
    });

    Route::prefix('change-profile')->group(function () {
        Route::get('/get-user', 'Cores\Rest\ChangeProfileCtrl@getUser');
        Route::post('/update-user', 'Cores\Rest\ChangeProfileCtrl@updateUser')->middleware('role');
        Route::post('/change-avatar', 'Cores\Rest\ChangeProfileCtrl@changeAvatar');
    });

    Route::prefix('media')->group(function () {
        #Lấy danh sách tài liệu
        Route::get('/', 'Cores\Rest\MediaCtrl@allFiles');
        #Tải tài liệu
        Route::get('/download', 'Cores\Rest\MediaCtrl@downloadFile');
        #lấy danh sách năm có tài liệu đính kèm
        Route::get('/all-year', 'Cores\Rest\MediaCtrl@allYear')->name('media.allYear');
        #thêm mới tài liệu
        Route::post('/', 'Cores\Rest\MediaCtrl@insert');
        #upload tài liệu
        Route::post('/upload', 'Cores\Rest\MediaCtrl@upload');
        #Xóa tài liệu
        Route::delete('/{id}', 'Cores\Rest\MediaCtrl@destroy');
        #my upload
        Route::post('/upload-file', 'Cores\Rest\MediaCtrl@uploadFile');
        Route::post('/upload-ckeditor', 'Cores\Rest\MediaCtrl@uploadCkeditor');
    });

    Route::prefix('excel')->group(function () {
        #Lấy danh sách tài liệu
        Route::post('/loadContent', 'Cores\Rest\ExcelCtrl@loadContent');
    });

    Route::prefix('notification')->group(function () {
        #Thêm mới thông báo
        Route::post('/', 'Cores\Rest\NotifyCtrl@insert');
        #Lấy danh sách thông báo
        Route::get('/notify', 'Cores\Rest\NotifyCtrl@getAll');
        #Lấy danh sách thông báo đã gửi
        Route::get('/sentNotify', 'Cores\Rest\NotifyCtrl@getAllNotifySent');
        #Lấy danh sách thông báo chưa đọc
        Route::get('/unreadNotify', 'Cores\Rest\NotifyCtrl@getAllUnread');
        #Đánh dấu đã đọc
        Route::get('/markNotifyAsRead/{notify_id}', 'Cores\Rest\NotifyCtrl@markNotifyAsRead');
    });

    Route::prefix('province')->group(function () {
        Route::get('/', 'Cores\Rest\ProvinceCtrl@getAll');
        Route::get('/get-by-id', 'Cores\Rest\ProvinceCtrl@getById');
        Route::post('/insert', 'Cores\Rest\ProvinceCtrl@insert');
        Route::put('/update/{id}', 'Cores\Rest\ProvinceCtrl@update');
        Route::delete('/delete/{id}', 'Cores\Rest\ProvinceCtrl@delete');
    });
    Route::prefix('district')->group(function () {
        Route::get('/', 'Cores\Rest\DistrictCtrl@getAll');
        Route::get('/get-by-id', 'Cores\Rest\DistrictCtrl@getById');
        Route::get('/get-by-province', 'Cores\Rest\DistrictCtrl@getDistrictByProvinceId');
        Route::post('/insert', 'Cores\Rest\DistrictCtrl@insert');
        Route::put('/update/{id}', 'Cores\Rest\DistrictCtrl@update');
        Route::delete('/delete/{id}', 'Cores\Rest\DistrictCtrl@delete');
    });
    Route::prefix('village')->group(function () {
        Route::get('/', 'Cores\Rest\VillageCtrl@getAll');
        Route::get('/get-by-id', 'Cores\Rest\VillageCtrl@getById');
        Route::get('/get-by-district', 'Cores\Rest\VillageCtrl@getDistrictByDistrictId');
        Route::post('/insert', 'Cores\Rest\VillageCtrl@insert');
        Route::put('/update/{id}', 'Cores\Rest\VillageCtrl@update');
        Route::delete('/delete/{id}', 'Cores\Rest\VillageCtrl@delete');
    });
    Route::prefix('catalog')->group(function () {
        Route::get('/', 'Cores\Rest\CatalogCtrl@getAll');
    });
});

