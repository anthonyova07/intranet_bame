<?php

namespace Bame\Http\Controllers\Treasury\Queries;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;

class QueryController extends Controller {

    public function index(Request $request)
    {
        $datetime = new \Datetime;

        return view('treasury.queries.index', compact('datetime'));
    }

    //Reporte Encaje Legal
    public function reporte_encaje_legal(Request $request)
    {
        if (can_not_do('treasury_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        set_time_limit(600);

        $meta_data = [
            'Mes de Generación' => get_months($request->month_encaje_legal),
            'Moneda' => $request->currency_encaje_legal,
        ];

        $columns = DB::connection('ibs')
            ->select("SELECT
                REG_COLUMNA COLUMNA,
                REG_MONEDA MONEDA,
                DESCRIPCION
                FROM TEL_RENGLONES
                WHERE REG_MONEDA = '{$request->currency_encaje_legal}'");

        $results = [];

        foreach ($columns as $column) {
            $accounts_by_column = DB::connection('ibs')
                ->select("SELECT CTA_COLUMNA COLUMNA,CUENTAS CUENTA
                    FROM TEL_CUENTAS
                    WHERE CTA_MONEDA = '{$request->currency_encaje_legal}'
                    AND CTA_COLUMNA = {$column->columna}");

            $accounts_balance = [];

            foreach ($accounts_by_column as $account) {
                $account_balance = DB::connection('ibs')
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
                        FROM GLBLN
                        WHERE GLBGLN LIKE '{$account->cuenta}%'
                        GROUP BY GLBCCY,GLBGLN");

                array_push($accounts_balance, $account_balance);
            }

            $total = 0;

            foreach ($accounts_balance as $balances) {
                foreach ($balances as $balance) {
                    $balance = array_values(get_object_vars($balance));
                    $total += floatval($balance[2]);
                    for ($i=0; $i < $request->month_encaje_legal; $i++) {
                        $total += $balance[3 + $i];
                    }
                }
            }

            $results[str_replace(' ', '_', cap_str($column->columna . ' ' . $column->descripcion))] = abs($total);
        }

        $results = [(object) $results];

        do_log('Generó el Reporte de Tesorería ( reporte:Reporte Encaje Legal )');

        return view('layouts.queries.excel', compact('results', 'meta_data'));
    }

}
