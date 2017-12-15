<?php

require_once 'routes/home.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

    require_once 'routes/francis_rosario.php';

    require_once 'routes/security.php';

    require_once 'routes/events.php';

    require_once 'routes/marketing/index.php';

    require_once 'routes/administration/index.php';

    require_once 'routes/human_resources/index.php';

    require_once 'routes/compliance/index.php';

    require_once 'routes/treasury/index.php';

    require_once 'routes/process/index.php';

    require_once 'routes/customer/index.php';

    require_once 'routes/operation/index.php';

    require_once 'routes/notifications.php';

    require_once 'routes/ib.php';

    require_once 'routes/extranet.php';

    require_once 'routes/financial_calculations.php';
});

// DB::listen(function ($query) {
//     var_dump($query->sql);
//     var_dump($query->bindings);
//     //$query->time
// });
