<?php

Route::group(['prefix' => 'vacant'], function () {
    Route::post('apply/{id}', 'HumanResource\Vacant\VacantController@apply')->name('human_resources.vacant.apply');
    Route::post('eligible/{vacant}/{applicant}', 'HumanResource\Vacant\VacantController@eligible')->name('human_resources.vacant.eligible');
});

Route::resource('vacant', 'HumanResource\Vacant\VacantController');
