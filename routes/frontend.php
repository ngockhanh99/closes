<?php
Route::get('/', 'FrontEndController@index')->name('home');



Route::get('/article/{name}', 'ArticleController@index')->name('article');
Route::get('/article/{name}/{id}', 'ArticleController@getDetail')->name('article_detail');

Route::get('/commercial_connection/{name}', 'CommercialConnectionController@index')->name('commercial_connection');
Route::post('/commercial_connection/{name}/commercial_connection_detail', 'CommercialConnectionController@detail')->name('commercial_connection_detail');

Route::get('/ocop_product/{name}', 'OcopProductController@index')->name('ocop_product');
Route::post('/ocop_product/{name}/ocop_product_detail', 'OcopProductController@detail')->name('ocop_product_detail');

Route::get('/questionAnswerExpert/{name}', 'QuestionAnswerExpertCtrl@index')->name('questionAnswerExpert');
Route::get('/questionAnswerExpertDetail/{name}/{id}', 'QuestionAnswerExpertCtrl@detail')->name('questionAnswerExpertDetail');

Route::get('/reflect', 'ReflectCtrl@index')->name('reflect');
Route::get('/reflectDetail/{id}', 'ReflectCtrl@detail')->name('reflectDetail');