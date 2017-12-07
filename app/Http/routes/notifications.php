<?php

Route::group(['prefix' => 'notification'], function () {
    Route::get('all', 'Notification\NotificationController@all')->name('all');
    Route::get('notified/{id}', 'Notification\NotificationController@notified')->name('notified');
    Route::get('delete/{id}', 'Notification\NotificationController@delete')->name('delete');
});
