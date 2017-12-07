<?php

Route::group(['prefix' => 'extranet', 'namespace' => 'Extranet'], function () {

    Route::resource('users', 'UsersController');
    Route::resource('business', 'BusinessController');

});
