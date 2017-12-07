<?php

//Consulta del Historico
Route::resource('consultas/historicoproducto','Consultas\HistoricoProducto\ProductoController');

Route::get('reporteproductopdf/{cliente}','Consultas\HistoricoProducto\ProductoController@reportepdf');

Route::get('reportetransaccionpdf/{producto}','Consultas\HistoricoProducto\TransaccionController@reportetranspdf');

Route::get('consultas/historicoproducto/reportetrans/{cuenta}', 'Consultas\HistoricoProducto\TransaccionController@reportetrans');

//Actualizcion de clientes
Route::resource('cumplimiento/cliente','Cumplimiento\Cliente\CumstController');

//Actulaiza mensajes de Estados de cuentas de TC
Route::resource('mantenimientos/menstc','Mantenimientos\MensTC\Mensajecontroller');
Route::resource('mantenimientos/menstchst','Mantenimientos\MensTCHst\MensajeHstcontroller');

Route::get('reportehistoricomsg/{codigo}','Mantenimientos\MensTChst\MensajeHstcontroller@reportehistoricomsg');
