<?php

namespace Bame\Http\Controllers\HumanResource\Queries;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;

class QueryController extends Controller {

    //Reporte Cuentas tipo H201/H202
    public function reporte_cuentas()
    {
        $results = DB::connection('ibs')->select("select
            trim(acmopd) dia_apertura,
            trim(acmopm) mes_apertura,
            trim(acmopy) anio_apertura,
            trim(acmbrn) sucursal,
            trim(acmacc) numero_cuenta,
            trim(acmcun) codigo_cliente,
            trim(cusna1) nombre_cliente,
            trim(acmaty) producto,
            trim(acmpro) tipo,
            trim(acmast) estado,
            trim(acmccy) moneda,
            trim(acmgbl) *-1 saldo_libro,
            trim(acmiac) interes_por_pagar,
            trim(acmipl) interes_cobrado_anio,
            case when acmacd = '04' then 'Ahorro' else  'Corriente' end as tipo
            from acmst, cumst
            where cuscun = acmcun and
            acmpro in('H201','H202')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Vinculados por gestión
    public function reporte_vinculados_gestion()
    {
        $results = DB::connection('ibs')->select("select cuscun codigocliente,
            trim(cusna1) nombre,
            trim(cusuc1) vinculacion
            from cumst
            where cusuc1 in('G1','G2')");

        return view('layouts.queries.excel', compact('results'));
    }

}
