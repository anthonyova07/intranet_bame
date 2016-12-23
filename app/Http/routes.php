<?php

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'gestidoc'], function () {
    Route::get('marketing', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.marketing');
    Route::get('human_resources', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.human_resources');
    Route::get('process', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.process');
});

Route::get('break_coco', 'Marketing\MarketingController@coco')->name('coco');
Route::post('break_coco', 'Marketing\MarketingController@idea');

Route::get('news/{id}', 'Marketing\MarketingController@news')->name('home.news');

Route::get('gallery/{gallery?}', 'Marketing\MarketingController@gallery')->name('home.gallery');

Route::get('event/{id}', 'HomeController@event')->name('home.event');
Route::get('event/{id}/subscribers', 'HomeController@subscribers')->name('home.event.subscribers');

Route::get('vacant/{id}', 'HumanResource\HumanResourceController@vacant')->name('home.vacant');

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['prefix' => 'notification'], function () {
    Route::get('all/global', 'Notification\NotificationController@allGlobal')->name('all.global');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'security'], function () {

        Route::resource('menu', 'Security\MenuController');

        Route::group(['prefix' => 'menu/{menu}'], function ($menu) {
            Route::resource('submenu', 'Security\SubMenuController');
        });

        Route::resource('access', 'Security\AccessController', ['only' => [
            'index', 'store'
        ]]);

        Route::resource('log', 'Security\LogController', ['only' => [
            'index'
        ]]);

    });

    Route::group(['prefix' => 'events'], function () {
        Route::get('subscribe/{id}', 'Event\SubscriptionController@subscribe')->name('event.subscribe');
        Route::get('unsubscribe_reason/{id}', 'Event\SubscriptionController@unsubscribe_reason')->name('event.unsubscribe_reason');
        Route::get('unsubscribe/{event}/{user}', 'Event\SubscriptionController@unsubscribe')->name('event.unsubscribe');
        Route::get('subscribe/accompanist/{event}/{accompanist}', 'Event\SubscriptionController@subscribeAccompanist')->name('event.subscribe.accompanist');
        Route::get('unsubscribe/accompanist/{event}/{user}/{accompanist}', 'Event\SubscriptionController@unsubscribeAccompanist')->name('event.unsubscribe.accompanist');
        Route::get('subscribers/print/{event}/{format}', 'Event\SubscriptionController@print')->name('event.subscribers.print');

        Route::resource('accompanist', 'Event\AccompanistController');
    });

    Route::group(['prefix' => 'marketing'], function () {
        Route::resource('news', 'Marketing\News\NewsController');

        Route::resource('break_coco', 'Marketing\Coco\CocoController', ['only' => [
            'index', 'store'
        ]]);

        Route::group(['prefix' => 'break_coco'], function () {
            Route::resource('ideas', 'Marketing\Coco\IdeaController', ['only' => [
                'index', 'show'
            ]]);
        });

        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);

        Route::resource('event', 'Event\EventController');

        Route::resource('gallery', 'Marketing\Gallery\GalleryController');

        Route::post('gallery/upload/{gallery}', 'Marketing\Gallery\GalleryController@upload')->name('marketing.gallery.upload');
        Route::delete('gallery/delete_image/{gallery}/{image}', 'Marketing\Gallery\GalleryController@delete_image')->name('marketing.gallery.delete_image');
    });

    Route::group(['prefix' => 'human_resources'], function () {
        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);

        Route::group(['prefix' => 'calendar'], function () {
            Route::resource('group', 'HumanResource\Calendar\GroupController', ['only' => [
                'create', 'store', 'edit', 'update'
            ]]);

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

        Route::group(['prefix' => 'vacant'], function () {
            Route::post('apply/{id}', 'HumanResource\Vacant\VacantController@apply')->name('human_resources.vacant.apply');
            Route::post('eligible/{vacant}/{applicant}', 'HumanResource\Vacant\VacantController@eligible')->name('human_resources.vacant.eligible');
        });

        Route::resource('vacant', 'HumanResource\Vacant\VacantController');

        Route::resource('event', 'Event\EventController');
    });

    Route::group(['prefix' => 'process'], function () {
        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);
    });

    Route::resource('customer', 'Customer\CustomerController', ['only' => [
        'index'
    ]]);

    Route::group(['prefix' => 'customer'], function () {
        Route::resource('ncf', 'Customer\Ncf\NcfController', ['only' => [
            'index', 'show', 'destroy'
        ]]);

        Route::group(['prefix' => 'ncf'], function () {
            Route::resource('{invoice}/detail', 'Customer\Ncf\DetailController', ['only' => [
                'index', 'edit', 'update', 'destroy'
            ]]);

            Route::resource('no_ibs/new', 'Customer\Ncf\NoIbs\NoIbsController', ['only' => [
                'index', 'store','destroy'
            ]]);

            Route::group(['prefix' => 'no_ibs/new'], function () {
                Route::resource('detail', 'Customer\Ncf\NoIbs\NoIbsDetailController', ['only' => [
                    'create', 'store', 'edit', 'update', 'destroy'
                ]]);
            });

            Route::resource('divisa/new', 'Customer\Ncf\Divisa\DivisaController', ['only' => [
                'index', 'store','destroy'
            ]]);

            Route::group(['prefix' => 'divisa/new'], function () {
                Route::resource('detail', 'Customer\Ncf\Divisa\DivisaDetailController', ['only' => [
                    'edit', 'update', 'destroy'
                ]]);
            });
        });
    });

    Route::group(['prefix' => 'operation'], function () {
        Route::group(['prefix' => 'tdc'], function () {
            Route::resource('receipt', 'Operation\Tdc\Receipt\TdcReceiptController', ['only' => [
                'index', 'store'
            ]]);
        });
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('all', 'Notification\NotificationController@all')->name('all');
        Route::get('notified/{id}', 'Notification\NotificationController@notified')->name('notified');
        Route::get('delete/{id}', 'Notification\NotificationController@delete')->name('delete');
    });

    Route::group(['prefix' => 'ib'], function () {
        Route::resource('transactions', 'IB\Transaction\TransactionController', ['only' => [
            'index'
        ]]);
    });

});

// DB::listen(function ($query) {
//     var_dump($query->sql);
//     var_dump($query->bindings);
//     //$query->time
// });
