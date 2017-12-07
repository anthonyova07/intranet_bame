<?php

Route::group(['prefix' => 'marketing'], function () {
    require_once 'news.php';

    require_once 'faqs.php';

    require_once 'break_coco.php';

    Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
        'index', 'store', 'destroy'
    ]]);

    Route::resource('event', 'Event\EventController');

    require_once 'gallery.php';

    Route::resource('lottery', 'Marketing\Lottery\LotteryController', ['only' => [
        'index', 'create'
    ]]);
});
