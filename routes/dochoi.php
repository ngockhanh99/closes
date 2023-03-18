<?php

Route::prefix('dochoi')->group(function()
{
    Route::prefix('danhmuc')->group(function(){
        Route::get('/','Dochoi\DanhmucCtrl@getAll');
        Route::post('/insert','Dochoi\DanhmucCtrl@insert')->middleware('role');
        Route::put('/update/{id}','Dochoi\DanhmucCtrl@update')->middleware('role');
        Route::delete('/delete/{id}','Dochoi\DanhmucCtrl@delete')->middleware('role');
    });
    Route::prefix('mau')->group(function(){
        Route::get('/','Dochoi\MauCtrl@getAll');
        Route::post('/insert','Dochoi\MauCtrl@insert')->middleware('role');
        Route::put('/update/{id}','Dochoi\MauCtrl@update')->middleware('role');
        Route::delete('/delete/{id}','Dochoi\MauCtrl@delete')->middleware('role');
    });
    Route::prefix('size')->group(function(){
        Route::get('/','Dochoi\SizeCtrl@getAll');
    });
    Route::prefix('loaisanpham')->group(function(){
        Route::get('/','Dochoi\LoaisanphamCtrl@getAll');
        Route::post('/insert','Dochoi\LoaisanphamCtrl@insert')->middleware('role');
        Route::put('/update/{id}','Dochoi\LoaisanphamCtrl@update')->middleware('role');
        Route::delete('/delete/{id}','Dochoi\LoaisanphamCtrl@delete')->middleware('role');
    });
    Route::prefix('sanpham')->group(function(){
        Route::get('/','Dochoi\SanphamCtrl@getAll');
        Route::post('/insert','Dochoi\SanphamCtrl@insert')->middleware('role');
        Route::put('/update/{id}','Dochoi\SanphamCtrl@update')->middleware('role');
        Route::delete('/delete/{id}','Dochoi\SanphamCtrl@delete')->middleware('role');
    });
    Route::get('/product/{id}', 'ProductController@index')->name('product');
    Route::get('/list-product/{id}', 'ProductController@listProduct')->name('listProduct');
    Route::post('/add-to-cart', 'Dochoi\OrderDraftCtrl@insert')->name('insert-cart');
    Route::post('/order', 'Dochoi\OrderCtrl@insert')->name('insert-order');
  
});

Route::prefix('home')->group(function()
{
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/register', 'LoginController@register')->name('register');
});

Route::get('/cart', 'CartController@index')->name('cart');