<?php

namespace Bame\Http\Controllers;

use Illuminate\Http\Request;
use Bame\Http\Requests\ConsultaEncartesRequest;

class ConsultaController extends Controller {

    public function getEncarte(ConsultaEncartesRequest $request) {
        $con_ibs = \Bame\Models\ConDB::getConDBIBS();
        $stmt = $con_ibs->prepare('SELECT COUNT(*) CANTIDAD FROM IBSBLAOBJ.SADENTR00 WHERE STSEN_ENTR = \'\'');
        $stmt->execute();
        return view('consultas.encartes', ['cantidad' => intval($stmt->fetch()->CANTIDAD)]);
    }

    public function postEncarte(ConsultaEncartesRequest $request) {

        $sql = 'SELECT '
                . 'NUMTA_ENTR TARJETA, '
                . 'IDENT_ENTR CEDULA, '
                . 'NOMB1_ENTR NOMBRE1, '
                . 'NOMB2_ENTR NOMBRE2, '
                . 'APEL1_ENTR APELLIDO1, '
                . 'APEL2_ENTR APELLIDO2, '
                . 'LIMRD_ENTR CREDITO_RD, '
                . 'LIMUS_ENTR CREDITO_US, '
                . 'CICLO_ENTR CICLO, '
                . 'EDIFI_ENTR EDIFICIO, '
                . 'BARRI_ENTR BARRIO, '
                . 'CALLE_ENTR CALLE, '
                . 'CIUDA_ENTR CIUDAD, '
                . 'CODT1_ENTR CODTEL1, '
                . 'TELRE_ENTR TELRES, '
                . 'CODT2_ENTR CODTEL2, '
                . 'TELOF_ENTR TELOFICINA, '
                . 'EXTEL_ENTR EXTENSION, '
                . 'CODT3_ENTR CODTEL3, '
                . 'CELUL_ENTR TELCELULAR, '
                . 'COMEN_ENTR COMENTARIO, '
                . '(SELECT '
                . 'NOMBR_DESC '
                . 'FROM IBSBLAOBJ.SATDESC00 '
                . 'WHERE PREFI_DESC = \'SAT_TSOL\' AND CODIG_DESC = TIPSO_ENTR) AS TIPO, '
                . '(SELECT '
                . 'DESCR_BIN '
                . 'FROM ENVIA.ENCARTBIN '
                . 'WHERE NUMTA_BIN = SUBSTR(NUMTA_ENTR,1,6)) AS TIPOD '
                . 'FROM IBSBLAOBJ.SADENTR00 WHERE NUMTA_ENTR <> 0 ';

        $masivo = false;

        if ($request->identificacion) {
            $request->identificacion = str_replace('-', '', $request->identificacion);
            $sql .= ' AND IDENT_ENTR = \'' . $request->identificacion . '\'';
        }

        if ($request->tarjeta) {
            $request->tarjeta = str_replace('-', '', $request->tarjeta);
            $sql .= ' AND NUMTA_ENTR = \'' . $request->tarjeta . '\'';
        }

        if ($request->fecha) {
            $request->fecha = str_replace('-', '', $request->fecha);
            $sql .= ' AND FECEN_ENTR = \'' . $request->fecha . '\'';
        }

        if (!$request->identificacion and !$request->tarjeta and !$request->fecha) {
            $masivo = true;
            $sql .= ' AND STSEN_ENTR = \'\' ';
        }

        $sql .= 'ORDER BY NUMTA_ENTR ';

        $sql .= 'FETCH FIRST ' . env('ENCARTE_NUMERO_MAXIMO') . ' ROWS ONLY';

        $con_ibs = \Bame\Models\ConDB::getConDBIBS();
        /*
         * Cambiar en PROD a getConDBITC
         */
        $con_itc = \Bame\Models\ConDB::getConDBIBS();

        $stmt = $con_ibs->prepare($sql);
        $stmt->execute();

        $tarjetas = collect($stmt->fetchAll());

        if (!$tarjetas->count()) {
            return back()->with('error', 'No existen encartes para imprimir.');
        }

        $tarjetas_procesadas = $tarjetas->pluck('TARJETA')->toArray();

        require_once base_path() . '\vendor\spipu\html2pdf\html2pdf.class.php';

        $tarjetas->each(function ($item, $key) use ($con_itc) {
            $item->TIPOD = ucwords(strtolower(trim($item->TIPOD)));
            $item->NOMBRE1 = ucwords(strtolower(trim($item->NOMBRE1)));
            $item->NOMBRE2 = ucwords(strtolower(trim($item->NOMBRE2)));
            $item->APELLIDO1 = ucwords(strtolower(trim($item->APELLIDO1)));
            $item->APELLIDO2 = ucwords(strtolower(trim($item->APELLIDO2)));
            $item->APELLIDO2 = ucwords(strtolower(trim($item->APELLIDO2)));

            $cedula_buscar = $item->CEDULA;
            $item->CEDULA = trim($item->CEDULA);
            $item->CEDULA = (strlen(trim($item->CEDULA)) == 11) ? substr($item->CEDULA, 0, 3) . '-' . substr($item->CEDULA, 3, 7) . '-' . substr($item->CEDULA, 10, 11) : $item->CEDULA;

            $item->EDIFICIO = ucwords(strtolower(trim($item->EDIFICIO)));
            $item->BARRIO = ucwords(strtolower(trim($item->BARRIO)));
            $item->CALLE = ucwords(strtolower(trim($item->CALLE)));
            $item->CIUDAD = ucwords(strtolower(trim($item->CIUDAD)));

            $item->TARJETA = trim($item->TARJETA);
            $item->TARJETA = substr($item->TARJETA, 0, 4) . '-****-****-' . substr($item->TARJETA, 12, 4);
            $tarjeta_pdf = str_replace('*', 'x', $item->TARJETA);

            $item->CREDITO_RD = number_format($item->CREDITO_RD, 2);
            $item->CREDITO_US = number_format($item->CREDITO_US, 2);
            $item->CICLO = intval($item->CICLO);
            $item->COMENTARIO = ucwords(strtolower(trim($item->COMENTARIO)));
            $item->TIPO = ucwords(strtolower(trim($item->TIPO)));

            $item->CODTEL1 = trim($item->CODTEL1);
            $item->TELRES = trim($item->TELRES);

            $item->CODTEL3 = trim($item->CODTEL3);
            $item->TELCELULAR = trim($item->TELCELULAR);

            $item->CODTEL2 = trim($item->CODTEL2);
            $item->TELOFICINA = trim($item->TELOFICINA);

            $item->EXTENSION = trim($item->EXTENSION);

            if ($item->CODTEL1 == 0) {
                $sql = 'SELECT CUSHPN VALOR FROM BADCYFILES.CUMST WHERE CUSLN3 = \'' . $cedula_buscar . '\'';
                $stmt = $con_itc->prepare($sql);
                $stmt->execute();
                $valor = $stmt->fetch();
                if ($valor) {
                    $valor = $valor->VALOR;
                    $item->CODTEL1 = substr($valor, 0, 3);
                    $item->TELRES = substr($valor, 3, 7);
                }
            }

            if ($item->CODTEL3 == 0) {
                $sql = 'SELECT CUSPH1 VALOR FROM BADCYFILES.CUMST WHERE CUSLN3 = \'' . $cedula_buscar . '\'';
                $stmt = $con_itc->prepare($sql);
                $stmt->execute();
                $valor = $stmt->fetch();
                if ($valor) {
                    $valor = $valor->VALOR;
                    $item->CODTEL3 = substr($valor, 0, 3);
                    $item->TELCELULAR = substr($valor, 3, 7);
                }
            }

            if ($item->CODTEL2 == 0) {
                $sql = 'SELECT CUSPHN VALOR FROM BADCYFILES.CUMST WHERE CUSLN3 = \'' . $cedula_buscar . '\'';
                $stmt = $con_itc->prepare($sql);
                $stmt->execute();
                $valor = $stmt->fetch();
                if ($valor) {
                    $valor = $valor->VALOR;
                    $item->CODTEL2 = substr($valor, 0, 3);
                    $item->TELOFICINA = substr($valor, 3, 7);
                }
            }

            $item->FOTO = '';

            if (strlen($item->CEDULA) == 13) {
                $ced_1 = substr($item->CEDULA, 0, 3);
                $ced_2 = substr($item->CEDULA, 4, 2);
                $ced_3 = substr($item->CEDULA, 6, 2);
                $item->FOTO = env('ENCARTES_URL_FOTO') . $ced_1 . '\\' . $ced_2 . '\\' . $ced_3 . '\\' . $item->CEDULA . '.jpg';
            }

            if (!file_exists($item->FOTO)) {
                $item->FOTO = base_path('\\public\\images\\noFoto.jpg');
            }

            $html = view('pdfs.encartes', ['tarjeta' => $item])->render();
            $html2pdf = new \HTML2PDF('P', 'A4', 'es', true, 'UTF-8', [2, 3, 133, 2]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->WriteHTML($html);
            $html2pdf->Output(base_path('pdfs\\encartes\\') . $tarjeta_pdf . '.pdf', 'F');
        });

        $sql = 'UPDATE IBSBLAOBJ.SADENTR00 SET STSEN_ENTR = \'P\' WHERE NUMTA_ENTR IN (\'' . implode('\', \'', $tarjetas_procesadas) . '\')';
        $con_ibs->prepare($sql)->execute();

        if ($masivo) {
            return back()->with('masivo', $masivo);
        }

        return back()->with('success', 'Los Encartes han sido generados correctamente.')->with('masivo', $masivo);
    }

}
