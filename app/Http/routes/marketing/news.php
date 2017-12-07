<?php

Route::group(['prefix' => 'news'], function () {
    Route::get('print/{id}', 'Marketing\News\NewsController@print')->name('marketing.news.print');
});

Route::resource('news', 'Marketing\News\NewsController');
