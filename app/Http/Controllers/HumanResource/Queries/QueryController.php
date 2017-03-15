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
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('ibs')
            ->select("SELECT
                ACMOPD||'/'||ACMOPM||'/'||CASE WHEN ACMOPY > 9 THEN '20' ELSE '200' END||ACMOPY FECHA_APERTURA,
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
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('ibs')
            ->select("SELECT
                CUSCUN CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE,
                TRIM(CUSUC1) VINCULACION
                FROM CUMST
                WHERE CUSUC1 IN('G1','G2')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Oficial asignado (244: Bianca / 187: Victoria)
    public function reporte_oficial_asignado()
    {
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('ibs')
            ->select("SELECT
                TRIM(CUSCUN) CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE,
                TRIM(CUSOFC) CODIGO_OFICIAL_PRINCIPAL,
                TRIM(PRINCIPAL.CNODSC) NOMBRE_OFICIAL_PRINCIPAL,
                TRIM(CUSOF2) CODIGO_OFICIAL_SEGUNDO,
                TRIM(SEGUNDO.CNODSC) NOMBRE_OFICIAL_SEGUNDO
                FROM CUMST
                INNER JOIN CNOFC PRINCIPAL
                    ON PRINCIPAL.CNOCFL = '15'
                    AND PRINCIPAL.CNORCD = CUSOFC
                INNER JOIN CNOFC SEGUNDO
                    ON SEGUNDO.CNOCFL = '15'
                    AND SEGUNDO.CNORCD = CUSOF2
                WHERE CUSOFC IN('244','187')");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte Relación del Cliente como Empleado (Rel. 3)
    public function reporte_cliente_empleado()
    {
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('ibs')
            ->select("SELECT
                TRIM(CUSCUN) CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE
                FROM CUMST
                WHERE CUSOFC IN('244','187')
                AND CUSSTF = '3'");

        return view('layouts.queries.excel', compact('results'));
    }

    //Reporte de tarjeta empleado
    public function reporte_tdc_empleado()
    {
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('itc')
            ->select("SELECT
                TCACT_MTAR||'*' NUMERO_TARJETA,
                INDCL_MTAR||'*' IDENTIFICACION,
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

    //Reporte de prestamos empleados
    public function reporte_loan_empleado()
    {
        if (can_not_do('human_resources_queries')) {
            return 'Usted no tiene permisos para acceder a esta opción';
        }

        $results = DB::connection('ibs')
            ->select("SELECT
                TRIM(DEACUN) CODIGO_CLIENTE,
                TRIM(CUSNA1) NOMBRE,
                TRIM(DEAACC) NUMERO_PRODUCTO,
                TRIM(DEAPRO) CODIGO_PRODUCTO,
                TRIM(DEATYP) CODIGO_SUBPRODUCTO,
                TRIM(APCDSC) DESCRIPCION_PRODUCTO,
                TRIM(DEACCY) MONEDA,
                TRIM(DEAOAM) CREDITO,
                (SELECT
                    CASE
                        WHEN (DAYS(CURRENT DATE) - DAYS(DATE(CASE WHEN DLPPDY > 9 THEN '20' ELSE '200' END||DLPPDY||'-'||DLPPDM||'-'||DLPPDD))) > 0
                            THEN DAYS(CURRENT DATE) - DAYS(DATE(CASE WHEN DLPPDY > 9 THEN '20' ELSE '200' END||DLPPDY||'-'||DLPPDM||'-'||DLPPDD))
                            ELSE ''
                    END
                FROM DLPMT
                WHERE DLPACC = DEAACC
                    AND DLPPFL <> 'P'
                    ORDER BY DLPPNU ASC
                    FETCH FIRST 1 ROWS ONLY) DIAS_ATRASO,
                TRIM(DEARTE) TASA,
                TRIM(CNODSC) OFICIAL,
                TRIM(DEATRM) PLAZO_MESES,
                CASE
                    WHEN TRIM(DEATRC) = 'D' THEN 'dia/s'
                    WHEN TRIM(DEATRC) = 'M' THEN 'mes/es'
                    WHEN TRIM(DEATRC) = 'Y' THEN 'año/s'
                END PLAZO_TERMINO,
                DEASDD||'/'||DEASDM||'/'||CASE WHEN DEASDY > 9 THEN '20' ELSE '200' END||DEASDY FECHA_APERTURA
            FROM DEALS
            INNER JOIN CUMST
                ON CUSCUN = DEACUN
                AND CUSOFC IN('244','187')
            INNER JOIN APCLS
                ON APCCDE = DEAPRO
                AND APCTYP = DEATYP
            INNER JOIN CNOFC
                ON CNOCFL = '15'
                AND CNORCD = CUSOFC
            WHERE DEAACD = '10'");

        return view('layouts.queries.excel', compact('results'));
    }

}
