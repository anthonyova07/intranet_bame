<?php

Route::group(['prefix' => 'payroll'], function () {
    Route::get('my', 'HumanResource\Payroll\PayrollController@getPayRoll')->name('human_resources.payroll.my');
});

Route::resource('payroll', 'HumanResource\Payroll\PayrollController', ['only' => [
    'create', 'store'
]]);
