<?php

Route::group(['prefix' => 'administration'], function () {
    Route::resource('gestidoc', 'Administration\GestiDoc\GestiDocController', ['only' => [
        'index', 'store', 'update', 'destroy'
    ]]);
    Route::group(['prefix' => 'gestidoc'], function () {
        Route::get('download/{folder}/{file}', 'Administration\GestiDoc\GestiDocController@download')->name('administration.gestidoc.download');
    });
});
