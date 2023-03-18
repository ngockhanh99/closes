<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Đăng nhập
Route::post('/login', 'Cores\Rest\UserCtrl@authenticate');
//Đăng xuất
Route::delete('/logOut', 'Cores\Rest\UserCtrl@logOut')->middleware('jwt.verify');
Route::prefix('cores')->group(function () {
    Route::prefix('user')->group(function () {
        //Thay đổi mật khẩu
        Route::put('/{user_id}/changePassword', 'Cores\Rest\UserCtrl@changePassword')->where('user_id', '[0-9]+')->middleware('jwt.verify');
        #lay thong tin nguoi dung theo token
        Route::get('/token', 'Cores\Rest\UserCtrl@getUserByToken')->middleware('jwt.verify');
        Route::get('/single/{id}', 'Cores\Rest\UserCtrl@apiGetSingle');
    });
    Route::prefix('options')->group(function () {
        #Lấy danh sách đơn vị khảo sát
        Route::get('/site', 'Cores\Rest\OptionsCtrl@getSite');
    });
});

Route::prefix('rest')->group(function () {
    Route::prefix('media')->group(function () {
        #my upload
        Route::post('/upload-mobile', 'Cores\Rest\MediaCtrl@uploadMobile');
    });
    Route::prefix('change-profile')->group(function () {
        Route::post('/update-user', 'Cores\Rest\ChangeProfileCtrl@updateUser')->middleware('jwt.verify');
    });
});

Route::prefix('mca')->group(function () {
    Route::prefix('purchase-ask')->group(function () {
        Route::post('/', 'MCA\Rest\PurchaseAskCtrl@insert')->middleware('role');
    });
});
