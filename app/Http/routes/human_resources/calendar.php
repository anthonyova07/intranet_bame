<?php

Route::group(['prefix' => 'calendar'], function () {
    Route::resource('group', 'HumanResource\Calendar\GroupController', ['only' => [
        'create', 'store', 'edit', 'update'
    ]]);

    Route::group(['prefix' => 'date'], function () {
        Route::post('loadfile', 'HumanResource\Calendar\DateController@loadfile')->name('human_resources.calendar.date.loadfile');
        Route::get('delete/{id}', 'HumanResource\Calendar\DateController@delete')->name('human_resources.calendar.date.delete');
    });

    Route::resource('date', 'HumanResource\Calendar\DateController', ['only' => [
        'create', 'store', 'edit', 'update'
    ]]);

    Route::resource('birthdate', 'HumanResource\Calendar\BirthdateController', ['only' => [
        'store'
    ]]);
});

Route::resource('calendar', 'HumanResource\Calendar\CalendarController', ['only' => [
    'index'
]]);
