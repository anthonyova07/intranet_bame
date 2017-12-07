<?php

Route::group(['prefix' => 'human_resources'], function () {
    Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
        'index', 'store', 'destroy'
    ]]);

    require_once 'calendar.php';

    require_once 'employee.php';

    require_once 'vacant.php';

    Route::resource('event', 'Event\EventController');

    require_once 'queries.php';

    require_once 'payroll.php';

    require_once 'request.php';
});
