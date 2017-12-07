<?php

Route::group(['prefix' => 'operation'], function () {
    Route::group(['prefix' => 'tdc'], function () {
        Route::resource('receipt', 'Operation\Tdc\Receipt\TdcReceiptController', ['only' => [
            'index', 'store'
        ]]);

        Route::group(['prefix' => 'transactions'], function () {
            Route::resource('days', 'Operation\Tdc\Transaction\TransactionDaysController', ['only' => [
                'index'
            ]]);
        });
    });
});
