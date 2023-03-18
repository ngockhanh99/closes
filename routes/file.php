<?php
use UniSharp\LaravelFilemanager\Middlewares\CreateDefaultFolder;
use UniSharp\LaravelFilemanager\Middlewares\MultiUser;

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    setlocale(LC_ALL,'C.UTF-8');
    $middleware = [ CreateDefaultFolder::class, MultiUser::class ];
    $as = 'unisharp.lfm.';
    $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';
    Route::group(compact('middleware', 'as', 'namespace'), function () {
        $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';
        // display main layout
        Route::get('/', [
            'uses' => $namespace . 'LfmController@show',
            'as' => 'show',
        ]);

        // display integration error messages
        Route::get('/errors', [
            'uses' => $namespace . 'LfmController@getErrors',
            'as' => 'getErrors',
        ]);

        // upload
        Route::any('/upload', [
            'uses' => $namespace . 'UploadController@upload',
            'as' => 'upload',
        ]);

        // list images & files
        Route::get('/jsonitems', [
            'uses' => $namespace . 'ItemsController@getItems',
            'as' => 'getItems',
        ]);

        Route::get('/move', [
            'uses' => $namespace . 'ItemsController@move',
            'as' => 'move',
        ]);

        Route::get('/domove', [
            'uses' => $namespace . 'ItemsController@domove',
            'as' => 'domove'
        ]);

        // folders
        Route::get('/newfolder', [
            'uses' => $namespace . 'FolderController@getAddfolder',
            'as' => 'getAddfolder',
        ]);

        // list folders
        Route::get('/folders', [
            'uses' => $namespace . 'FolderController@getFolders',
            'as' => 'getFolders',
        ]);

        // crop
        Route::get('/crop', [
            'uses' => $namespace . 'CropController@getCrop',
            'as' => 'getCrop',
        ]);
        Route::get('/cropimage', [
            'uses' => $namespace . 'CropController@getCropimage',
            'as' => 'getCropimage',
        ]);
        Route::get('/cropnewimage', [
            'uses' => $namespace . 'CropController@getNewCropimage',
            'as' => 'getCropimage',
        ]);

        // rename
        Route::get('/rename', [
            'uses' => $namespace . 'RenameController@getRename',
            'as' => 'getRename',
        ]);

        // scale/resize
        Route::get('/resize', [
            'uses' => $namespace . 'ResizeController@getResize',
            'as' => 'getResize',
        ]);
        Route::get('/doresize', [
            'uses' => $namespace . 'ResizeController@performResize',
            'as' => 'performResize',
        ]);

        // download
        Route::get('/download', [
            'uses' => $namespace . 'DownloadController@getDownload',
            'as' => 'getDownload',
        ]);

        // delete
        Route::get('/delete', [
            'uses' => $namespace . 'DeleteController@getDelete',
            'as' => 'getDelete',
        ]);

        Route::get('/demo', $namespace . 'DemoController@index');
    });
});
