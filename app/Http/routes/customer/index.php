<?php

Route::group(['prefix' => 'customer'], function () {
    require_once 'ncf.php';

    require_once 'claim.php';

    require_once 'request.php';

    require_once 'maintenance.php';
});

Route::resource('customer', 'Customer\CustomerController', ['only' => [
    'index'
]]);
