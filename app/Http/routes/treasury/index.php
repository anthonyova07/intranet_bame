<?php

Route::group(['prefix' => 'treasury'], function () {
    require_once 'queries.php';

    require_once 'rates.php';
});
