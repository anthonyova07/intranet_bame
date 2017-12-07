<?php

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
