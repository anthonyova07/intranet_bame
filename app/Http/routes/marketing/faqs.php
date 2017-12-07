<?php

Route::group(['prefix' => 'faqs'], function () {
    Route::resource('themes', 'Marketing\FAQs\ThemesController');
});

Route::resource('faqs', 'Marketing\FAQs\FAQsController');
