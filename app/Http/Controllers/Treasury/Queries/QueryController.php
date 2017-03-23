<?php

namespace Bame\Http\Controllers\Treasury\Queries;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;

class QueryController extends Controller {

    public function index(Request $request)
    {
        return view('treasury.queries.index');
    }

    //Reporte Encaje Legal
    public function reporte_encaje_legal(Request $request)
    {
        // if (can_not_do('human_resources_queries')) {
        //     return 'Usted no tiene permisos para acceder a esta opción';
        // }

        $columns = DB::connection('ibs')
            ->select("SELECT *
                FROM TEL_RENGLONES
                    WHERE REG_MONEDA = '{$request->currency_encaje_legal}'");

        $accounts_chunks = collect();

        foreach ($columns as $column) {
            $accounts_by_column = DB::connection('ibs')
                ->select("SELECT CTA_COLUMNA COLUMNA,CUENTAS CUENTA
                    FROM TEL_CUENTAS
                        WHERE CTA_MONEDA = '{$request->currency_encaje_legal}'
                        AND CTA_COLUMNA = {$column->reg_columna}");

            $accounts_chunks->push($accounts_by_column);
        }

        foreach ($accounts_chunks as $accounts) {
            foreach ($accounts as $account) {
                DB::connection('ibs')
                    ->select("SELECT
                        GLBCCY,
                        GLBGLN,
                        SUM(GLBBBL) GLBBBL,
                        SUM(GLBJAB) GLBJAB,
                        SUM(GLBFEB) GLBFEB,
                        SUM(GLBMAB) GLBMAB,
                        SUM(GLBAPB) GLBAPB,
                        SUM(GLBMYB) GLBMYB,
                        SUM(GLBJUB) GLBJUB,
                        SUM(GLBJLB) GLBJLB,
                        SUM(GLBAUB) GLBAUB,
                        SUM(GLBSEB) GLBSEB,
                        SUM(GLBOCB) GLBOCB,
                        SUM(GLBNOB) GLBNOB,
                        SUM(GLBDEB) GLBDEB
                        FROM BADCYFILES.GLBLN
                            WHERE GLBGLN LIKE '{$account->cuenta}%'
                            GROUP BY GLBCCY,GLBGLN");
            }
        }

        do_log('Generó el Reporte de Tesorería  ( reporte:Reporte Encaje Legal )');

        return view('layouts.queries.excel', compact('results'));
    }

}
