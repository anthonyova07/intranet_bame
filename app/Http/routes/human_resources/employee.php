<?php

Route::group(['prefix' => 'employee'], function () {
    Route::get('export', 'HumanResource\Employee\EmployeeController@export')->name('human_resources.employee.export');

    Route::post('load', 'HumanResource\Employee\EmployeeController@load')->name('human_resources.employee.load');

    Route::group(['prefix' => '{type}'], function () {
        Route::resource('param', 'HumanResource\Employee\ParamController', ['only' => [
            'create', 'store', 'edit', 'update'
        ]]);

        Route::post('loadparams', 'HumanResource\Employee\ParamController@loadparams')->name('human_resources.employee.{type}.params.loadparams');
    });
});

Route::resource('employee', 'HumanResource\Employee\EmployeeController');
