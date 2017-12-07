<?php

Route::group(['prefix' => 'process'], function () {
    Route::resource('closing_cost', 'Process\ClosingCost\ClosingCostController', ['only' => [
        'create', 'store'
    ]]);

    Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
        'index', 'store', 'destroy'
    ]]);

    require_once 'request.php';
});
