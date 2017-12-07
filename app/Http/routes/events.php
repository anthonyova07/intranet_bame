<?php

Route::group(['prefix' => 'events'], function () {
    Route::get('subscribe/{id}', 'Event\SubscriptionController@subscribe')->name('event.subscribe');
    Route::get('unsubscribe_reason/{id}', 'Event\SubscriptionController@unsubscribe_reason')->name('event.unsubscribe_reason');
    Route::get('unsubscribe/{event}/{user}', 'Event\SubscriptionController@unsubscribe')->name('event.unsubscribe');
    Route::get('subscribe/accompanist/{event}/{accompanist}', 'Event\SubscriptionController@subscribeAccompanist')->name('event.subscribe.accompanist');
    Route::get('unsubscribe/accompanist/{event}/{user}/{accompanist}', 'Event\SubscriptionController@unsubscribeAccompanist')->name('event.unsubscribe.accompanist');
    Route::get('subscribers/print/{event}/{format}', 'Event\SubscriptionController@print')->name('event.subscribers.print');

    Route::resource('accompanist', 'Event\AccompanistController');
});
