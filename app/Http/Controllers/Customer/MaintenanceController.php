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

        $customer = null;
        $countries = collect();
        // $provinces = collect();

        if ($request->core == 'ibs') {
            $countries = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', '03')->orderBy('description')->get();
            // $provinces = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', 'PV')->orderBy('description')->get();
        }

        if ($request->identification) {

            $this->validate($request, [
                'identification' => 'required|alpha_num|max:15',
                'core' => 'required|in:ibs,itc',
            ], [
                'core.required' => 'Debe indicar al CORE donde dara el mantenimiento.'
            ]);

            $customer = Customer::SearchByIdentification($request->identification)->first();

            if (!$customer) {
                return redirect(route('customer.maintenance.create'))->with('warning', 'La información suministrada no corresponde a ningún cliente en IBS.');
            }

            session()->put('customer_maintenance', $request->identification);
        }

        $regions = Region::orderByDesc()->get();
        $ways_sending_statements = Description::wherePrefix('SAS_ENVCOR')->orderByDescription()->get();

        return view('customer.maintenance.create')
            ->with('customer', $customer)
            ->with('countries', $countries)
            // ->with('provinces', $provinces)
            ->with('regions', $regions)
            ->with('tdc', $request->tdc)
            ->with('core', $request->core)
            ->with('ways_sending_statements', $ways_sending_statements);
    }

    public function store(MaintenanceRequest $r)
    {
        // dd($r->all());

        $datetime = new Datetime();

        $customer = Customer::SearchByIdentification(session('customer_maintenance'))->first();

        if ($r->core == 'ibs') {
            $customer->cusna2 = $r->street_ibs;
            $customer->cusna4 = $r->building_house_number_ibs;
            $customer->cusctr = substr(trim(DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', '03')->where('cnorcd', $r->country_ibs)->orderBy('description')->first()->description), 0, 20);
            $customer->cusste = $r->province_ibs;
            $customer->cusuc8 = $r->city_ibs;
            $customer->cusuc7 = $r->sector_ibs;
            $customer->cuspob = $r->postal_mail_ibs;
            $customer->cuszpc = $r->zip_code_ibs;
            $customer->cusmlc = $r->mail_type_ibs;
            $customer->cusiad = $r->mail_ibs;
            $customer->cushpn = $r->house_phone_ibs;
            $customer->cusphn = $r->office_phone_ibs;
            $customer->cusfax = $r->fax_phone_ibs;
            $customer->cusph1 = $r->movil_phone_ibs;

            $customer->save();
        }

        if ($r->core == 'itc') {

            $this->save_address_one($r, $customer, $datetime);

            $this->save_address_two($r, $customer, $datetime);

        }

        do_log('Realizó Mantenimiento del cliente ( number:' . strip_tags($customer->getCode()) . ' )');

        session()->forget('customer_maintenance');

        return redirect(route('customer.maintenance.create'))->with('success', 'Los cambios fueron guardados correctamente.');
    }

    protected function load(Request $request)
    {
        $ibs_query = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->orderBy('description');

        if ($request->search == 'province_ibs') {
            return $ibs_query->where('cnocfl', 'PV')->get();
        }

        if ($request->search == 'city_ibs') {
            if ($request->country == 'DR') {
                $ibs_query->where('cnomid', $request->province);
            }

            return $ibs_query->where('cnocfl', 'PI')->get();
        }

        if ($request->search == 'sector_ibs') {
            if ($request->country == 'DR') {
                $ibs_query->where('cnomid', $request->province);
                $ibs_query->where('cnomic', $request->city);
            }

            return $ibs_query->where('cnocfl', 'PE')->get();
        }

        //******************************************
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

    private function save_address_one($r, $customer, $datetime)
    {
        $tdc = $customer->actives_creditcards->get($r->tdc);

        $address = [
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

        if ($customer->actives_creditcards->get($r->tdc)->address_one) {
            $address = array_merge($address, [
                'USRMO_MDIR' => 'BADINTRANE', //Usuario Modificacion
                'FECMO_MDIR' => $datetime->format('Ymd'), //Fecha Modificacion
                'HORMO_MDIR' => $datetime->format('His'), //Hora Modificacion
            ]);

            $customer->actives_creditcards->get($r->tdc)->address_one()->update($address);
        } else {
            $address = array_merge($address, [
                'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
            ]);

            $customer->actives_creditcards->get($r->tdc)->address_one()->insert($address);
        }
    }

    private function save_address_two($r, $customer, $datetime)
    {
        $tdc = $customer->actives_creditcards->get($r->tdc);

        $address = [
            'CODBA_MDIR' => 1, //Codigo Banco
            'CODCI_MDIR' => 1, //Cod. Cia a Procesar
            'NUSOL_MDIR' => 0, //Numero Solicitud
            'TCACT_MDIR' => $tdc->getNumber(), //Numero de Tarjeta
            'CODCL_MDIR' => $customer->getCode(), //Codigo Cliente
            'IDDIR_MDIR' => 2, //Tipo Direccion
            'FOREE_MDIR' => $r->ways_sending_statement_2_itc, //Forma Envio Estado
            'SECTP_MDIR' => 0, //Secuencia Tipo/Direc
            'CIFCL_MDIR' => '', //LLave Cif Cliente
            'CODPA_MDIR' => $r->country_2_itc, //Codigo Pais
            'REGIO_MDIR' => $r->region_2_itc, //Codigo Region
            'PROVI_MDIR' => $r->province_2_itc, //Codigo Provincia
            'CIUCL_MDIR' => $r->city_2_itc, //Codigo Ciudad
            'MUNIC_MDIR' => $r->municipality_2_itc, //Codigo Municipio
            'SECTR_MDIR' => $r->sector_2_itc, //Codigo Sector
            'BARRI_MDIR' => $r->neighborhood_2_itc, //Codigo Barrio
            'CALCL_MDIR' => $r->street_2_itc, //Codigo Calles
            'EDIFC_MDIR' => $r->building_name_2_itc, //Nombre Edificio
            'MANZC_MDIR' => $r->block_2_itc, //Codigo Manzana
            'NUMCA_MDIR' => $r->house_number_2_itc, //No. Casa/Apartamento
            'KILOM_MDIR' => $r->km_2_itc, //Kilometro Si es Carr
            'CALL1_MDIR' => $r->in_street_1_2_itc, //Entre Cuales Calle 1
            'CALL2_MDIR' => $r->in_street_2_2_itc, //Entre Cuales Calle 2
            'INSTD_MDIR' => $r->special_instruction_2_itc, //Instruccion Especial
            'ZONAP_MDIR' => $r->postal_zone_2_itc, //Zona Postal
            'APOST_MDIR' => $r->postal_mail_2_itc, //Apartado Postal
            'IDTEP_MDIR' => 0, //Codigo Pais
            'AREAP_MDIR' => $r->main_phone_area_2_itc, //Area Telefono
            'NUTEP_MDIR' => $r->main_phone_number_2_itc, //Numero Telefono
            'EXTEP_MDIR' => $r->main_phone_number_2_itc, //Extension Telefono
            'IDTES_MDIR' => 0, //Codigo Pais
            'AREAS_MDIR' => $r->secundary_phone_area_2_itc, //Area Telefono
            'NUTES_MDIR' => $r->secundary_phone_number_2_itc, //Numero Telefono
            'EXTES_MDIR' => $r->secundary_phone_number_2_itc, //Extension Telefono
            'IDTCP_MDIR' => 0, //Codigo Pais
            'ARECP_MDIR' => $r->main_cell_area_2_itc, //Area Telefono
            'NUTCP_MDIR' => $r->main_cell_number_2_itc, //Numero Telefono
            'IDTCS_MDIR' => 0, //Codigo Pais
            'ARECS_MDIR' => $r->secundary_cell_area_2_itc, //Area Telefono
            'NUTCS_MDIR' => $r->secundary_cell_number_2_itc, //Numero Telefono
            'AREAF_MDIR' => $r->fax_area_2_itc, //Area Fax
            'NUMFX_MDIR' => $r->fax_number_2_itc, //Numero de Fax
            'EMAIL_MDIR' => $r->mail_2_itc, //Correo Electronico
            'STSDI_MDIR' => '', //Status Direccion
            'STSCA_MDIR' => '', //Status de Cambios
            // 'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
            // 'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
            // 'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
            // 'USRMO_MDIR' => 1, //Usuario Modificacion
            // 'FECMO_MDIR' => 1, //Fecha Modificacion
            // 'HORMO_MDIR' => 1, //Hora Modificacion
        ];

        if ($customer->actives_creditcards->get($r->tdc)->address_two) {
            $address = array_merge($address, [
                'USRMO_MDIR' => 'BADINTRANE', //Usuario Modificacion
                'FECMO_MDIR' => $datetime->format('Ymd'), //Fecha Modificacion
                'HORMO_MDIR' => $datetime->format('His'), //Hora Modificacion
            ]);

            $customer->actives_creditcards->get($r->tdc)->address_two()->update($address);
        } else {
            $address = array_merge($address, [
                'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
            ]);

            $customer->actives_creditcards->get($r->tdc)->address_two()->insert($address);
        }
    }
}
