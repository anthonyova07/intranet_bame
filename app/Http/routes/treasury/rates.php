<?php

Route::group(['prefix' => 'rates'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::resource('{product}/detail', 'Treasury\Rates\ProductDetailController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);
    });

    Route::resource('product', 'Treasury\Rates\ProductController', ['only' => [
        'index', 'create', 'store', 'edit', 'update'
    ]]);
});

Route::resource('rates', 'Treasury\Rates\RateController', ['only' => [
    'index', 'create', 'store', 'show'
]]);
