<?php

require 'frontend.php';
require 'cores.php';
require 'file.php';
require 'dochoi.php';


Route::prefix('iframe')->group(function () {
    Route::get('/report', 'IframeController@report');
});