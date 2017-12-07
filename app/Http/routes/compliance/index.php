<?php

Route::group(['prefix' => 'compliance'], function () {
    Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
        'index', 'store', 'destroy'
    ]]);
});
