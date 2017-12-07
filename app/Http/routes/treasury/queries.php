<?php

Route::group(['prefix' => 'queries'], function () {
    Route::get('reporte_encaje_legal', 'Treasury\Queries\QueryController@reporte_encaje_legal')->name('treasury.queries.reporte_encaje_legal');
});

Route::resource('queries', 'Treasury\Queries\QueryController', ['only' => [
    'index'
]]);
