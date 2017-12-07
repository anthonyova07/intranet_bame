<?php

Route::group(['prefix' => 'ib'], function () {
    Route::resource('transactions', 'IB\Transaction\TransactionController', ['only' => [
        'index'
    ]]);
});
