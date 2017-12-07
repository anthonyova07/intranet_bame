<?php

Route::group(['prefix' => 'request', 'namespace' => 'Customer\Requests\Tdc'], function () {
    Route::resource('tdc', 'TdcRequestController', ['only' => [
        'index', 'create', 'store', 'show'
    ]]);
});

Route::group(['prefix' => 'maintenance', 'namespace' => 'Customer\Maintenance'], function () {
    Route::get('load', 'MaintenanceController@load')->name('customer.maintenance.load');
    Route::get('approve', 'MaintenanceController@approve')->name('customer.maintenance.approve');
    Route::get('print/{id}', 'MaintenanceController@print')->name('customer.maintenance.print');
});

Route::resource('maintenance', 'Customer\Maintenance\MaintenanceController', ['only' => [
    'index', 'create', 'store'
]]);
