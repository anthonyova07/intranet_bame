<?php

Route::resource('financial_calculations', 'FinancialCalculations\FinancialCalculationController', ['only' => [
    'index'
]]);

Route::group(['prefix' => 'financial_calculations', 'namespace' => 'FinancialCalculations'], function () {
    Route::group(['prefix' => '{type}'], function () {
        Route::resource('param', 'ParamController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);
    });
});
