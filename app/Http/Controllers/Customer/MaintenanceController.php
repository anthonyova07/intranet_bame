<?php

namespace Bame\Http\Controllers\Customer;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use Datetime;
use Bame\Models\Customer\Customer;
use Bame\Models\Operation\Tdc\Description;
use Bame\Http\Requests\Customer\MaintenanceRequest;
use Bame\Models\Customer\Product\CreditCardAddress;
use Bame\Models\Customer\Product\CreditCardAddress\{Country, City, Municipality, Neighborhood, Province, Region, Sector, Street};

class MaintenanceController extends Controller
{
    public function create(Request $request)
    {
        if ($request->cancel) {
            session()->forget('customer_maintenance');

            return redirect(route('customer.maintenance.create'));
        }

        if ($request->identification && !session()->has('customer_maintenance')) {

            $this->validate($request, [
                'identification' => 'required|alpha_num|max:15',
                'core' => 'required|in:ibs,itc',
            ], [
                'core.required' => 'Debe indicar al CORE donde dara el mantenimiento.'
            ]);

            $customer = Customer::with('actives_creditcards')->SearchByIdentification($request->identification)->first();

            if (!$customer) {
                return redirect(route('customer.maintenance.create'))->with('warning', 'La información suministrada no corresponde a ningún cliente en IBS.');
            }

            session()->put('customer_maintenance', $customer);
        }

        $regions = Region::orderByDesc()->get();
        $ways_sending_statements = Description::wherePrefix('SAS_ENVCOR')->orderByDescription()->get();

        return view('customer.maintenance.create')
            ->with('regions', $regions)
            ->with('tdc', $request->tdc)
            ->with('core', $request->core)
            ->with('ways_sending_statements', $ways_sending_statements)
            ->with('customer', session('customer_maintenance'));
    }

    public function store(MaintenanceRequest $r)
    {
        // dd($r->all());

        $datetime = new Datetime();

        $customer = session('customer_maintenance');

        if ($r->core == 'ibs') {
            // $customer->cusmlc = $r->
        }

        if ($r->core == 'itc') {
            $tdc = $customer->actives_creditcards->get($r->tdc);

            $address_one = [
                'CODBA_MDIR' => 1, //Codigo Banco
                'CODCI_MDIR' => 1, //Cod. Cia a Procesar
                'NUSOL_MDIR' => 0, //Numero Solicitud
                'TCACT_MDIR' => $tdc->getNumber(), //Numero de Tarjeta
                'CODCL_MDIR' => $customer->getCode(), //Codigo Cliente
                'IDDIR_MDIR' => 1, //Tipo Direccion
                'FOREE_MDIR' => $r->ways_sending_statement_itc, //Forma Envio Estado
                'SECTP_MDIR' => 0, //Secuencia Tipo/Direc
                'CIFCL_MDIR' => '', //LLave Cif Cliente
                'CODPA_MDIR' => $r->country_itc, //Codigo Pais
                'REGIO_MDIR' => $r->region_itc, //Codigo Region
                'PROVI_MDIR' => $r->province_itc, //Codigo Provincia
                'CIUCL_MDIR' => $r->city_itc, //Codigo Ciudad
                'MUNIC_MDIR' => $r->municipality_itc, //Codigo Municipio
                'SECTR_MDIR' => $r->sector_itc, //Codigo Sector
                'BARRI_MDIR' => $r->neighborhood_itc, //Codigo Barrio
                'CALCL_MDIR' => $r->street_itc, //Codigo Calles
                'EDIFC_MDIR' => $r->building_name_itc, //Nombre Edificio
                'MANZC_MDIR' => $r->block_itc, //Codigo Manzana
                'NUMCA_MDIR' => $r->house_number_itc, //No. Casa/Apartamento
                'KILOM_MDIR' => $r->km_itc, //Kilometro Si es Carr
                'CALL1_MDIR' => $r->in_street_1_itc, //Entre Cuales Calle 1
                'CALL2_MDIR' => $r->in_street_2_itc, //Entre Cuales Calle 2
                'INSTD_MDIR' => $r->special_instruction_itc, //Instruccion Especial
                'ZONAP_MDIR' => $r->postal_zone_itc, //Zona Postal
                'APOST_MDIR' => $r->postal_mail_itc, //Apartado Postal
                'IDTEP_MDIR' => 0, //Codigo Pais
                'AREAP_MDIR' => $r->main_phone_area_itc, //Area Telefono
                'NUTEP_MDIR' => $r->main_phone_number_itc, //Numero Telefono
                'EXTEP_MDIR' => $r->main_phone_number_itc, //Extension Telefono
                'IDTES_MDIR' => 0, //Codigo Pais
                'AREAS_MDIR' => $r->secundary_phone_area_itc, //Area Telefono
                'NUTES_MDIR' => $r->secundary_phone_number_itc, //Numero Telefono
                'EXTES_MDIR' => $r->secundary_phone_number_itc, //Extension Telefono
                'IDTCP_MDIR' => 0, //Codigo Pais
                'ARECP_MDIR' => $r->main_cell_area_itc, //Area Telefono
                'NUTCP_MDIR' => $r->main_cell_number_itc, //Numero Telefono
                'IDTCS_MDIR' => 0, //Codigo Pais
                'ARECS_MDIR' => $r->secundary_cell_area_itc, //Area Telefono
                'NUTCS_MDIR' => $r->secundary_cell_number_itc, //Numero Telefono
                'AREAF_MDIR' => $r->fax_area_itc, //Area Fax
                'NUMFX_MDIR' => $r->fax_number_itc, //Numero de Fax
                'EMAIL_MDIR' => $r->mail_itc, //Correo Electronico
                'STSDI_MDIR' => '', //Status Direccion
                'STSCA_MDIR' => '', //Status de Cambios
                // 'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                // 'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                // 'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                // 'USRMO_MDIR' => 1, //Usuario Modificacion
                // 'FECMO_MDIR' => 1, //Fecha Modificacion
                // 'HORMO_MDIR' => 1, //Hora Modificacion
            ];
            $a = $customer->actives_creditcards->get($r->tdc)->address_1;
dd($a);
            if ($customer->actives_creditcards->get($r->tdc)->address_1) {
                $address_one = array_merge($address_one, [
                    'USRMO_MDIR' => 'BADINTRANE', //Usuario Modificacion
                    'FECMO_MDIR' => $datetime->format('Ymd'), //Fecha Modificacion
                    'HORMO_MDIR' => $datetime->format('His'), //Hora Modificacion
                ]);

                $customer->actives_creditcards->get($r->tdc)->address_1()->update($address_one);
            } else {
                $address_one = array_merge($address_one, [
                    'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                    'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                    'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                ]);

                $customer->actives_creditcards->get($r->tdc)->address_1()->insert($address_one);
            }
        }
    }

    protected function load(Request $request)
    {
        $sql_search = "SELECT ";

        if ($request->search == 'province') {
            $field_rel = 'PROVI_RELD';
            $field_code = "PROVI_TPRV";
            $field_description = "DESPV_TPRV";
            $table = "SASTPRV00";

            $sql_search .= $field_rel;
            $and_where = "";
            $group_by = $field_rel;
        }

        if ($request->search == 'city') {
            $field_rel = 'CIUDA_RELD';
            $field_code = "CIUDA_TCIU";
            $field_description = "DESCI_TCIU";
            $table = "SASTCIU00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$request->province}";
            $group_by = $field_rel;
        }

        if ($request->search == 'municipality') {
            $field_rel = 'MUNIC_RELD';
            $field_code = "MUNIC_TMUN";
            $field_description = "DESMC_TMUN";
            $table = "SASTMUN00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$request->province} AND CIUDA_RELD = {$request->city}";
            $group_by = $field_rel;
        }

        if ($request->search == 'sector') {
            $field_rel = 'SECTO_RELD';
            $field_code = "SECTO_TDSE";
            $field_description = "DESSE_TDSE";
            $table = "SASTDSE00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$request->province} AND CIUDA_RELD = {$request->city} AND MUNIC_RELD = {$request->municipality}";
            $group_by = $field_rel;
        }

        if ($request->search == 'neighborhood') {
            $field_rel = 'BARRI_RELD';
            $field_code = "BARRI_TDBA";
            $field_description = "DESBA_TDBA";
            $table = "SASTDBA00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$request->province} AND CIUDA_RELD = {$request->city} AND MUNIC_RELD = {$request->municipality} AND SECTO_RELD = {$request->sector}";
            $group_by = $field_rel;
        }

        if ($request->search == 'street') {
            $field_rel = 'CALLE_RELD';
            $field_code = "CALLE_TDCA";
            $field_description = "DESCA_TDCA";
            $table = "SASTDCA00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$request->province} AND CIUDA_RELD = {$request->city} AND MUNIC_RELD = {$request->municipality} AND SECTO_RELD = {$request->sector} AND BARRI_RELD = {$request->neighborhood}";
            $group_by = $field_rel;
        }

        $sql_search .= " IDS FROM SASRELD00 WHERE CODPA_RELD = '{$request->country}' AND REGIO_RELD = '{$request->region}' {$and_where} GROUP BY {$group_by}";
        $ids = collect(DB::connection('itc')->select($sql_search))->implode('ids', ',');

        $sql = "SELECT TRIM({$field_code}) code, TRIM({$field_description}) description FROM {$table} WHERE {$field_code} IN ({$ids}) ORDER BY {$field_description}";
        $result = collect(DB::connection('itc')->select($sql));

        return $result->toJson();
    }
}
