<?php

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'gestidoc'], function () {
    Route::get('marketing', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.marketing');
    Route::get('human_resources', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.human_resources');
    Route::get('process', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.process');
    Route::get('compliance', 'GestiDoc\GestiDocController@gestidoc')->name('gestidoc.compliance');
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

    //Consulta del Historico
    Route::resource('consultas/historicoproducto','Consultas\HistoricoProducto\ProductoController');

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

    Route::group(['prefix' => 'administration'], function () {
        Route::resource('gestidoc', 'Administration\GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'update', 'destroy'
        ]]);
        Route::group(['prefix' => 'gestidoc'], function () {
            Route::get('download/{folder}/{file}', 'Administration\GestiDoc\GestiDocController@download')->name('administration.gestidoc.download');
        });
    });

    Route::group(['prefix' => 'human_resources'], function () {
        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);

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

        Route::group(['prefix' => 'vacant'], function () {
            Route::post('apply/{id}', 'HumanResource\Vacant\VacantController@apply')->name('human_resources.vacant.apply');
            Route::post('eligible/{vacant}/{applicant}', 'HumanResource\Vacant\VacantController@eligible')->name('human_resources.vacant.eligible');
        });

        Route::resource('vacant', 'HumanResource\Vacant\VacantController');

        Route::resource('event', 'Event\EventController');

        Route::group(['prefix' => 'queries'], function () {
            Route::get('reporte_cuentas', 'HumanResource\Queries\QueryController@reporte_cuentas')->name('human_resources.queries.reporte_cuentas');
            Route::get('reporte_vinculados_gestion', 'HumanResource\Queries\QueryController@reporte_vinculados_gestion')->name('human_resources.queries.reporte_vinculados_gestion');
            Route::get('reporte_oficial_asignado', 'HumanResource\Queries\QueryController@reporte_oficial_asignado')->name('human_resources.queries.reporte_oficial_asignado');
            Route::get('reporte_cliente_empleado', 'HumanResource\Queries\QueryController@reporte_cliente_empleado')->name('human_resources.queries.reporte_cliente_empleado');
            Route::get('reporte_tdc_empleado', 'HumanResource\Queries\QueryController@reporte_tdc_empleado')->name('human_resources.queries.reporte_tdc_empleado');
            Route::get('reporte_loan_empleado', 'HumanResource\Queries\QueryController@reporte_loan_empleado')->name('human_resources.queries.reporte_loan_empleado');
        });

        Route::resource('queries', 'HumanResource\Queries\QueryController', ['only' => [
            'index'
        ]]);

        Route::group(['prefix' => 'request'], function () {
            Route::resource('{type}/param', 'HumanResource\Request\ParamController', ['only' => [
                'create', 'store', 'edit', 'update'
            ]]);

            Route::get('approve/{request_id}/{to_approve}/{type}', 'HumanResource\Request\ApproveController@approve')->name('human_resources.request.approve');
            Route::post('changestatus/{request_id}', 'HumanResource\Request\ApproveController@changestatus')->name('human_resources.request.changestatus');
            Route::get('attach/{request_id}/{file_name}', 'HumanResource\Request\RequestController@downloadAttach')->name('human_resources.request.downloadattach');
            Route::post('paid/{request_id}', 'HumanResource\Request\RequestController@paid')->name('human_resources.request.paid');

            Route::group(['prefix' => 'export'], function () {
                Route::get('excel', 'HumanResource\Request\RequestController@excel')->name('human_resources.request.export.excel');
            });
        });

        Route::resource('request', 'HumanResource\Request\RequestController', ['only' => [
            'index', 'create', 'store', 'show'
        ]]);
    });

    Route::group(['prefix' => 'compliance'], function () {
        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);
    });

    Route::group(['prefix' => 'treasury'], function () {
        Route::group(['prefix' => 'queries'], function () {
            Route::get('reporte_encaje_legal', 'Treasury\Queries\QueryController@reporte_encaje_legal')->name('treasury.queries.reporte_encaje_legal');
        });

        Route::resource('queries', 'Treasury\Queries\QueryController', ['only' => [
            'index'
        ]]);
    });

    Route::group(['prefix' => 'process'], function () {
        Route::resource('gestidoc', 'GestiDoc\GestiDocController', ['only' => [
            'index', 'store', 'destroy'
        ]]);

        Route::group(['prefix' => 'request'], function () {
            Route::resource('{type}/param', 'Process\Request\ParamController', ['only' => [
                'create', 'store', 'edit', 'update'
            ]]);

            Route::post('{process_request}/addusers', 'Process\Request\RequestController@addusers')->name('process.request.addusers');
            Route::get('{process_request}/deleteuser', 'Process\Request\RequestController@deleteuser')->name('process.request.deleteuser');

            Route::get('{process_request}/approval', 'Process\Request\RequestController@approval')->name('process.request.approval');

            Route::post('{process_request}/addstatus', 'Process\Request\RequestController@addstatus')->name('process.request.addstatus');

            Route::post('{process_request}/addattach', 'Process\Request\RequestController@addattach')->name('process.request.addattach');
            Route::get('{process_request}/downloadattach', 'Process\Request\RequestController@downloadattach')->name('process.request.downloadattach');
            Route::delete('{process_request}/deleteattach', 'Process\Request\RequestController@deleteattach')->name('process.request.deleteattach');

            Route::group(['prefix' => 'export'], function () {
                Route::get('status_count_pdf', 'Process\Request\ExportController@status_count_pdf')->name('process.request.export.status_count_pdf');
            });
        });

        Route::resource('request', 'Process\Request\RequestController', ['only' => [
            'index', 'create', 'store', 'show'
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

        Route::group(['prefix' => 'claim'], function () {
            Route::get('destroy', 'Customer\Claim\ClaimController@destroy')->name('customer.claim.destroy');

            Route::get('statuses/{id}', 'Customer\Claim\ClaimController@statuses')->name('customer.claim.statuses');

            Route::resource('{type}/param', 'Customer\Claim\ParamController', ['only' => [
                'create', 'store', 'edit', 'update'
            ]]);

            Route::resource('{claim_id}/{form_type}/form', 'Customer\Claim\ClaimFormController', ['only' => [
                'create', 'store', 'show'
            ]]);

            Route::get('approve/{claim_id}/{to_approve}', 'Customer\Claim\ClaimController@getApprove')->name('customer.claim.approve');
            Route::post('approve/{claim_id}/{to_approve}', 'Customer\Claim\ClaimController@postApprove');

            Route::get('complete/{claim_id}', 'Customer\Claim\ClaimController@getClose')->name('customer.claim.close');
            Route::post('complete/{claim_id}', 'Customer\Claim\ClaimController@postClose');

            Route::get('attach/{claim_id}', 'Customer\Claim\ClaimController@getAttach')->name('customer.claim.attach');
            Route::post('attach/{claim_id}', 'Customer\Claim\ClaimController@postAttach');

            Route::group(['prefix' => 'attach'], function () {
                Route::get('download/{claim_id}/{attach}', 'Customer\Claim\ClaimController@downloadAttach')->name('customer.claim.attach.download');
                Route::delete('delete/{claim_id}/{attach}', 'Customer\Claim\ClaimController@deleteAttach')->name('customer.claim.attach.delete');
            });

            Route::group(['prefix' => 'print'], function () {
                Route::get('claim/{id}', 'Customer\Claim\PrintController@claim')->name('customer.claim.print.claim');
                Route::get('claim/{claim_id}/{form_type}/form/{form_id}', 'Customer\Claim\PrintController@form')->name('customer.claim.print.form');
            });

            Route::group(['prefix' => 'excel'], function () {
                Route::get('claim', 'Customer\Claim\ExcelController@claim')->name('customer.claim.excel.claim');
            });
        });

        Route::resource('claim', 'Customer\Claim\ClaimController', ['only' => [
            'index', 'create', 'store', 'show'
        ]]);
    });

    Route::group(['prefix' => 'operation'], function () {
        Route::group(['prefix' => 'tdc'], function () {
            Route::resource('receipt', 'Operation\Tdc\Receipt\TdcReceiptController', ['only' => [
                'index', 'store'
            ]]);

            Route::group(['prefix' => 'transactions'], function () {
                Route::resource('days', 'Operation\Tdc\Transaction\TransactionDaysController', ['only' => [
                    'index'
                ]]);
            });
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
