<?php

namespace Bame\Http\Controllers\HumanResource\Queries;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;

class QueryController extends Controller {

    public function index(Request $request)
    {
        return view('human_resources.queries.index');
    }

    //Reporte Cuentas tipo H201/H202/H251
    public function reporte_cuentas()
    {
        $results = DB::connection('ibs')
            ->select("SELECT
                CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(TRIM(ACMOPD), '/'), TRIM(ACMOPM)), '/'),
                    CASE WHEN ACMOPY > 9 THEN '20' ELSE '200' END
                ), TRIM(ACMOPY)) FECHA_APERTURA,
                TRIM(BRNNME) SUCURSAL,
                TRIM(ACMACC) NUMERO_CUENTA,
                TRIM(ACMCUN) CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE_CLIENTE,
                TRIM(ACMATY) PRODUCTO,
                TRIM(ACMPRO) CODIGO_PRODUCTO,
                CASE WHEN TRIM(ACMACD) = '04' THEN 'AHORRO' ELSE 'CORRIENTE' END AS TIPO_CUENTA,
                TRIM(APCDSC) PRODUCTO_DESCRIPCION,
                TRIM(ACMAST) ESTADO,
                TRIM(ACMCCY) MONEDA,
                TRIM(ACMGBL) *-1 SALDO_LIBRO,
                TRIM(ACMIAC) INTERES_POR_PAGAR,
                TRIM(ACMIPL) INTERES_COBRADO_ANIO
                FROM ACMST
                INNER JOIN APCLS
                    ON APCCDE = ACMPRO
                    AND APCTYP = ACMATY
                INNER JOIN CNTRLBRN
                    ON ACMBRN = BRNNUM
                INNER JOIN CUMST
                    ON CUSCUN = ACMCUN
                WHERE ACMPRO IN('H201','H202', 'H251')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Vinculados por gestión
    public function reporte_vinculados_gestion()
    {
        $results = DB::connection('ibs')
            ->select("SELECT CUSCUN CODIGOCLIENTE,
                TRIM(CUSNA1) NOMBRE,
                TRIM(CUSUC1) VINCULACION
                FROM CUMST
                WHERE CUSUC1 IN('G1','G2')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Oficial asignado (244: Bianca / 187: Victoria)
    public function reporte_oficial_asignado()
    {
        $results = DB::connection('ibs')
            ->select("SELECT
                TRIM(CUSCUN) CODIGO_CLIENTE,
                TRIM(C.CUSNA1) NOMBRE,
                TRIM(C.CUSOFC) CODIGO_OFICIAL_PRINCIPAL,
                TRIM((SELECT
                    CNODSC
                    FROM CNOFC
                    WHERE CNOCFL = '15'
                    AND CNORCD = C.CUSOFC)) AS NOMBRE_OFICIAL_PRINCIPAL,
                TRIM(C.CUSOF2) CODIGO_OFICIAL_SEGUNDO,
                TRIM((SELECT
                    CNODSC
                    FROM CNOFC
                    WHERE CNOCFL = '15'
                    AND CNORCD = C.CUSOF2)) AS NOMBRE_OFICIAL_SEGUNDO
                FROM CUMST C
                WHERE C.CUSOFC IN('244','187')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Relación del Cliente como Empleado (Rel. 3)
    public function reporte_cliente_empleado()
    {
        $results = DB::connection('ibs')
            ->select("SELECT
                TRIM(CUSCUN) CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE
                FROM CUMST C
                WHERE C.CUSOFC IN('244','187')
                AND CUSSTF = '3'");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte de tarjeta empleado
    public function reporte_tdc_empleado()
    {
        $results = DB::connection('itc')
            ->select("SELECT
                CONCAT(TCACT_MTAR, '*') NUMERO_TARJETA,
                CONCAT(INDCL_MTAR, '*') IDENTIFICACION,
                CASE
                    WHEN CODPR_MTAR = '08' THEN 'DIFERIDO BANDA'
                    WHEN CODPR_MTAR = '28' THEN 'DIFERIDO CHIP'
                    WHEN CODPR_MTAR = '11' THEN 'EMPLEADO BANDA'
                    WHEN CODPR_MTAR = '25' THEN 'EMPLEADO CHIP'
                END PRODUCTO,
                CASE
                    WHEN SUBSTR(TCACT_MTAR,0,7) = '485912' THEN 'SI' ELSE 'NO'
                END ES_COMBUSTIBLE,
                NOMPL_MTAR NOMBRE_CLIENTE,
                NOMBR_DESC ESTATUS,
                CASE
                    WHEN MONED_MSAL = '214' THEN 'DOP'
                    WHEN MONED_MSAL = '840' THEN 'USD'
                END MONEDA,
                (SACTC_MSAL + SACTI_MSAL + SACTO_MSAL + SACTG_MSAL) SALDO_ACTUAL,
                (SACCA_MSAL + SACIN_MSAL + SACCO_MSAL + SACCG_MSAL + SACCB_MSAL + SACIB_MSAL + SACOB_MSAL + SACAG_MSAL) SALDO_CORTE,
                LIMRD_MSAL LIMITE_CREDITO,
                CANPV_MSAL CANTIDAD_PAGOS_VENCIDOS,
                CODCI_MTAR CICLO
                FROM SATMTAR00
                INNER JOIN SATMSAL00
                    ON TCACT_MSAL = TCACT_MTAR
                INNER JOIN SATDESC00
                    ON PREFI_DESC = 'SAT_STSTC' AND CODIG_DESC = STSRD_MTAR
                WHERE (CODPR_MTAR = '08'
                OR CODPR_MTAR = '28'
                OR CODPR_MTAR = '11'
                OR CODPR_MTAR = '25')
                AND STSRD_MTAR NOT IN('09','07','05')");

        return view('layouts.queries.excel', compact('results'));
    }

}
