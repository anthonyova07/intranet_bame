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
Route::get('news_list', 'Marketing\MarketingController@news_list')->name('home.news_list');

Route::get('gallery/{gallery?}', 'Marketing\MarketingController@gallery')->name('home.gallery');

Route::get('faqs', 'Marketing\MarketingController@faqs')->name('home.faqs');

Route::get('rates', 'Treasury\TreasuryController@rates')->name('home.rates');

Route::get('event/{id}', 'HomeController@event')->name('home.event');
Route::get('event/{id}/subscribers', 'HomeController@subscribers')->name('home.event.subscribers');

Route::get('vacant/{id}', 'HumanResource\HumanResourceController@vacant')->name('home.vacant');

Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

Route::group(['prefix' => 'notification'], function () {
    Route::get('all/global', 'Notification\NotificationController@allGlobal')->name('all.global');
});

Route::group(['prefix' => 'financial_calculations', 'namespace' => 'FinancialCalculations'], function () {
    Route::resource('loan', 'LoanController', ['only' => [
        'index'
    ]]);

    Route::resource('investment', 'InvestmentController', ['only' => [
        'index'
    ]]);
});
