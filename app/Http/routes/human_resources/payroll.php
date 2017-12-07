<?php

Route::group(['prefix' => 'payroll'], function () {
    Route::get('my', 'HumanResource\Payroll\PayrollController@getPayRoll')->name('human_resources.payroll.my');
    Route::get('migrate_payroll_detail', 'HumanResource\Payroll\PayrollController@migratePayrollDetail')->name('human_resources.payroll.migrate_payroll_detail');
});

Route::resource('payroll', 'HumanResource\Payroll\PayrollController', ['only' => [
    'create', 'store'
]]);
