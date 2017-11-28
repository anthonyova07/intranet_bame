<?php

namespace Bame\Http\Controllers\Customer\Maintenance;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use Datetime;
use Bame\Models\Customer\Customer;
use Bame\Models\Customer\Maintenance\{MaintenanceIbs, MaintenanceItc};
use Bame\Models\Operation\Tdc\Description;
use Bame\Http\Requests\Customer\Maintenance\MaintenanceRequest;
use Bame\Models\Customer\Product\CreditCardAddress;
use Bame\Models\Customer\Product\CreditCardAddress\{Country, City, Municipality, Neighborhood, Province, Region, Sector, Street};

class MaintenanceController extends Controller
{
    protected $ways_sending_statements;

    public function __construct()
    {
        $this->ways_sending_statements = Description::wherePrefix('SAS_ENVCOR')->orderByDescription()->get();
    }

    public function index(Request $request)
    {
        $maintenances = MaintenanceIbs::lastest();

        if ($request->term) {
            $term = cap_str($request->term);

            $maintenances = $maintenances->orWhere('clinumber', 'like', '%' . $term . '%')
                        ->orWhere('cliident', 'like', '%' . $term . '%')
                        ->orWhere('tdcnumber', 'like', '%' . $term . '%');
        }

        if ($request->pending_approval) {
            $maintenances->where('isapprov', false);
        }

        if ($request->date_from) {
            $maintenances->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $maintenances->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $maintenances = $maintenances->paginate();

        return view('customer.maintenance.index')
            ->with('maintenances', $maintenances);
    }

    public function create(Request $request)
    {
        if ($request->cancel) {
            session()->forget('customer_maintenance');
            session()->forget('customer_maintenance_core');
            session()->forget('tdc_numbers');

            return redirect(route('customer.maintenance.create'));
        }

        $maintenances = collect();

        $customer = null;
        $core = null;
        $tdc = $request->tdc ?? 0;

        $countries_ibs = collect();
        $provinces_ibs = collect();
        $cities_ibs = collect();
        $sectors_ibs = collect();

        $provinces_itc = collect();
        $cities_itc = collect();
        $municipalities_itc = collect();
        $sectors_itc = collect();
        $neighborhoods_itc = collect();
        $streets_itc = collect();

        $provinces_2_itc = collect();
        $cities_2_itc = collect();
        $municipalities_2_itc = collect();
        $sectors_2_itc = collect();
        $neighborhoods_2_itc = collect();
        $streets_2_itc = collect();

        $address_one = null;
        $address_two = null;

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

            $core = $request->core;

            session()->put('customer_maintenance', $request->identification);
            session()->put('customer_maintenance_core', $core);
        }

        if (session()->has('customer_maintenance')) {
            $customer = Customer::SearchByIdentification(session('customer_maintenance'))->first();
            $core = session('customer_maintenance_core');
        }

        if ($core == 'ibs') {
            $countries_ibs = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', '03')->orderBy('description')->get();

            $provinces_ibs = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', 'PV')->orderBy('description')->get();

            $cities_ibs = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', 'PI')->where('cnomid', $customer->getProvinceCode())->orderBy('description')->get();

            $sectors_ibs = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', 'PE')->where('cnomid', $customer->getProvinceCode())->where('cnomic', $customer->getCityCode())->orderBy('description')->get();
        }

        if ($core == 'itc') {
            $address_one = null;
            $address_two = null;

            if ($customer->actives_creditcards->count() > 0) {
                $address_one = $customer->actives_creditcards->get($tdc)->address_one;
                $address_two = $customer->actives_creditcards->get($tdc)->address_two;
            } else {
                session()->forget('customer_maintenance');
                session()->forget('customer_maintenance_core');

                return redirect()->route('customer.maintenance.create')->with('warning', 'Este Cliente no posee tarjeta de crédito en el sistema.');
            }

            if ($address_one) {
                $request->search = 'province';
                $request->country = 'DOM';
                $request->region = $address_one->getRegion();
                $provinces_itc = $this->load($request);

                $request->search = 'city';
                $request->province = $address_one->getProvince();
                $cities_itc = $this->load($request);

                $request->search = 'municipality';
                $request->city = $address_one->getCity();
                $municipalities_itc = $this->load($request);

                $request->search = 'sector';
                $request->municipality = $address_one->getMunicipality();
                $sectors_itc = $this->load($request);

                $request->search = 'neighborhood';
                $request->sector = $address_one->getSector();
                $neighborhoods_itc = $this->load($request);

                $request->search = 'street';
                $request->neighborhood = $address_one->getNeighborhood();
                $streets_itc = $this->load($request);
            }

            if ($address_two) {
                $request->search = 'province';
                $request->country = 'DOM';
                $request->region = $address_two->getRegion();
                $provinces_2_itc = $this->load($request);

                $request->search = 'city';
                $request->province = $address_two->getProvince();
                $cities_2_itc = $this->load($request);

                $request->search = 'municipality';
                $request->city = $address_two->getCity();
                $municipalities_2_itc = $this->load($request);

                $request->search = 'sector';
                $request->municipality = $address_two->getMunicipality();
                $sectors_2_itc = $this->load($request);

                $request->search = 'neighborhood';
                $request->sector = $address_two->getSector();
                $neighborhoods_2_itc = $this->load($request);

                $request->search = 'street';
                $request->neighborhood = $address_two->getNeighborhood();
                $streets_2_itc = $this->load($request);
            }
        }

        $regions = Region::orderByDesc()->get();

        $no_more_tdc = false;

        if (session('tdc_numbers')) {
            $no_more_tdc = session('tdc_numbers')->count() == ($customer->actives_creditcards->count() - 1);
        }

        return view('customer.maintenance.create')
            ->with('customer', $customer)

            ->with('countries_ibs', $countries_ibs)
            ->with('provinces_ibs', $provinces_ibs)
            ->with('cities_ibs', $cities_ibs)
            ->with('sectors_ibs', $sectors_ibs)

            ->with('provinces_itc', $provinces_itc)
            ->with('cities_itc', $cities_itc)
            ->with('municipalities_itc', $municipalities_itc)
            ->with('sectors_itc', $sectors_itc)
            ->with('neighborhoods_itc', $neighborhoods_itc)
            ->with('streets_itc', $streets_itc)

            ->with('provinces_2_itc', $provinces_2_itc)
            ->with('cities_2_itc', $cities_2_itc)
            ->with('municipalities_2_itc', $municipalities_2_itc)
            ->with('sectors_2_itc', $sectors_2_itc)
            ->with('neighborhoods_2_itc', $neighborhoods_2_itc)
            ->with('streets_2_itc', $streets_2_itc)

            ->with('regions', $regions)
            ->with('address_one', $address_one)
            ->with('address_two', $address_two)
            ->with('tdc', $tdc)
            ->with('core', $core)
            ->with('no_more_tdc', $no_more_tdc)
            ->with('ways_sending_statements', $this->ways_sending_statements);
    }

    public function store(MaintenanceRequest $r)
    {
        $datetime = new Datetime();

        $customer = Customer::SearchByIdentification(session('customer_maintenance'))->first();

        $maintenance_ibs = new MaintenanceIbs;

        $maintenance_ibs->id = uniqid(true);
        $maintenance_ibs->clinumber = $customer->getCode();
        $maintenance_ibs->cliident = session('customer_maintenance');
        $maintenance_ibs->typecore = $r->core;

        if ($r->core == 'itc') {
            $tdc_indexs = array_merge($r->tdc_additionals ?? [], [$r->tdc]);
            $tdc_numbers = collect();

            foreach ($tdc_indexs as $key => $value) {
                $tdc_numbers->push($customer->actives_creditcards->get($value)->getNumber());
            }

            if (session('tdc_numbers')) {
                session()->put('tdc_numbers', $tdc_numbers->merge(session('tdc_numbers'), $tdc_numbers));
            } else {
                session()->put('tdc_numbers', $tdc_numbers);
            }

            $maintenance_ibs->tdcnumber = $tdc_numbers->implode(',');
        }

        if ($r->core == 'ibs') {
            $maintenance_ibs->ibsstreet = $r->street_ibs;
            $maintenance_ibs->ibsbuhounu = $r->building_house_number_ibs;

            $maintenance_ibs->ibscountry = substr(trim(DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->where('cnocfl', '03')->where('cnorcd', $this->getCode($r->country_ibs))->orderBy('description')->first()->description), 0, 20);

            $maintenance_ibs->ibsprovinc = $this->getCode($r->province_ibs);
            $maintenance_ibs->ibsprovind = $this->getDesc($r->province_ibs);

            $maintenance_ibs->ibscityc = $this->getCode($r->city_ibs);
            $maintenance_ibs->ibscityd = $this->getDesc($r->city_ibs);

            $maintenance_ibs->ibssectorc = $this->getCode($r->sector_ibs);
            $maintenance_ibs->ibssectord = $this->getDesc($r->sector_ibs);

            $maintenance_ibs->ibsposmail = $r->postal_mail_ibs;
            $maintenance_ibs->ibszipcode = $r->zip_code_ibs;
            $maintenance_ibs->ibsmail = $r->mail_ibs;

            $maintenance_ibs->ibshouphon = $r->house_phone_ibs;
            $maintenance_ibs->ibsoffipho = $r->office_phone_ibs;
            $maintenance_ibs->ibsfaxphon = $r->fax_phone_ibs;
            $maintenance_ibs->ibsmovipho = $r->movil_phone_ibs;
        }

        $maintenance_ibs->isapprov = false;

        $maintenance_ibs->created_at = datetime();
        $maintenance_ibs->created_by = session()->get('user');
        $maintenance_ibs->createname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $maintenance_ibs->save();

        if ($r->core == 'itc') {

            $itc_dir_1 = new MaintenanceItc;

            $itc_dir_1->id  = uniqid(true) . '1';
            $itc_dir_1->parent_id = $maintenance_ibs->id;
            $itc_dir_1->dir_type = 1;

            $itc_dir_1->waysendsta = $r->ways_sending_statement_itc;

            $itc_dir_1->itccountrc = $this->getCode($r->country_itc);
            $itc_dir_1->itccountrd = $this->getDesc($r->country_itc);

            $itc_dir_1->itcregionc = $this->getCode($r->region_itc);
            $itc_dir_1->itcregiond = $this->getDesc($r->region_itc);

            $itc_dir_1->itcprovinc = $this->getCode($r->province_itc);
            $itc_dir_1->itcprovind = $this->getDesc($r->province_itc);

            $itc_dir_1->itccityc = $this->getCode($r->city_itc);
            $itc_dir_1->itccityd = $this->getDesc($r->city_itc);

            $itc_dir_1->itcmunicic = $this->getCode($r->municipality_itc);
            $itc_dir_1->itcmunicid = $this->getDesc($r->municipality_itc);

            $itc_dir_1->itcsectorc = $this->getCode($r->sector_itc);
            $itc_dir_1->itcsectord = $this->getDesc($r->sector_itc);

            $itc_dir_1->itcneighoc = $this->getCode($r->neighborhood_itc);
            $itc_dir_1->itcneighod = $this->getDesc($r->neighborhood_itc);

            $itc_dir_1->itcstreetc = $this->getCode($r->street_itc);
            $itc_dir_1->itcstreetd = $this->getDesc($r->street_itc);

            $itc_dir_1->itcbuiname = $r->building_name_itc;
            $itc_dir_1->itcblock = $r->block_itc;
            $itc_dir_1->itchousnum = $r->house_number_itc;
            $itc_dir_1->itckm = $r->km_itc;
            $itc_dir_1->itcinstre1 = $r->in_street_1_itc;
            $itc_dir_1->itcinstre2 = $r->in_street_2_itc;
            $itc_dir_1->itcspeinst = $r->special_instruction_itc;
            $itc_dir_1->itcposzone = $r->postal_zone_itc;
            $itc_dir_1->itcposmail = $r->postal_mail_itc;

            $itc_dir_1->itcmphoare = $r->main_phone_area_itc;
            $itc_dir_1->itcmphonum = $r->main_phone_number_itc;
            $itc_dir_1->itcmphoext = $r->main_phone_ext_itc;

            $itc_dir_1->itcsphoare = $r->secundary_phone_area_itc;
            $itc_dir_1->itcsphonum = $r->secundary_phone_number_itc;
            $itc_dir_1->itcsphoext = $r->secundary_phone_ext_itc;

            $itc_dir_1->itcmcelare = $r->main_cell_area_itc;
            $itc_dir_1->itcmcelnum = $r->main_cell_number_itc;

            $itc_dir_1->itcscelare = $r->secundary_cell_area_itc;
            $itc_dir_1->itcscelnum = $r->secundary_cell_number_itc;

            $itc_dir_1->itcfaxarea = $r->fax_area_itc;
            $itc_dir_1->itcfaxnumb = $r->fax_number_itc;

            $itc_dir_1->itcmail = $r->mail_itc;

            //---------------------------------

            $itc_dir_2 = new MaintenanceItc;

            $itc_dir_2->id  = uniqid(true) . '2';

            $itc_dir_2->parent_id = $maintenance_ibs->id;
            $itc_dir_2->dir_type = 2;

            $itc_dir_2->waysendsta = $r->ways_sending_statement_2_itc;

            $itc_dir_2->itccountrc = $this->getCode($r->country_2_itc);
            $itc_dir_2->itccountrd = $this->getDesc($r->country_2_itc);

            $itc_dir_2->itcregionc = $this->getCode($r->region_2_itc);
            $itc_dir_2->itcregiond = $this->getDesc($r->region_2_itc);

            $itc_dir_2->itcprovinc = $this->getCode($r->province_2_itc);
            $itc_dir_2->itcprovind = $this->getDesc($r->province_2_itc);

            $itc_dir_2->itccityc = $this->getCode($r->city_2_itc);
            $itc_dir_2->itccityd = $this->getDesc($r->city_2_itc);

            $itc_dir_2->itcmunicic = $this->getCode($r->municipality_2_itc);
            $itc_dir_2->itcmunicid = $this->getDesc($r->municipality_2_itc);

            $itc_dir_2->itcsectorc = $this->getCode($r->sector_2_itc);
            $itc_dir_2->itcsectord = $this->getDesc($r->sector_2_itc);

            $itc_dir_2->itcneighoc = $this->getCode($r->neighborhood_2_itc);
            $itc_dir_2->itcneighod = $this->getDesc($r->neighborhood_2_itc);

            $itc_dir_2->itcstreetc = $this->getCode($r->street_2_itc);
            $itc_dir_2->itcstreetd = $this->getDesc($r->street_2_itc);

            $itc_dir_2->itcbuiname = $r->building_name_2_itc;
            $itc_dir_2->itcblock = $r->block_2_itc;
            $itc_dir_2->itchousnum = $r->house_number_2_itc;
            $itc_dir_2->itckm = $r->km_2_itc;
            $itc_dir_2->itcinstre1 = $r->in_street_1_2_itc;
            $itc_dir_2->itcinstre2 = $r->in_street_2_2_itc;
            $itc_dir_2->itcspeinst = $r->special_instruction_2_itc;
            $itc_dir_2->itcposzone = $r->postal_zone_2_itc;
            $itc_dir_2->itcposmail = $r->postal_mail_2_itc;

            $itc_dir_2->itcmphoare = $r->main_phone_area_2_itc;
            $itc_dir_2->itcmphonum = $r->main_phone_number_2_itc;
            $itc_dir_2->itcmphoext = $r->main_phone_ext_2_itc;

            $itc_dir_2->itcsphoare = $r->secundary_phone_area_2_itc;
            $itc_dir_2->itcsphonum = $r->secundary_phone_number_2_itc;
            $itc_dir_2->itcsphoext = $r->secundary_phone_ext_2_itc;

            $itc_dir_2->itcmcelare = $r->main_cell_area_2_itc;
            $itc_dir_2->itcmcelnum = $r->main_cell_number_2_itc;

            $itc_dir_2->itcscelare = $r->secundary_cell_area_2_itc;
            $itc_dir_2->itcscelnum = $r->secundary_cell_number_2_itc;

            $itc_dir_2->itcfaxarea = $r->fax_area_2_itc;
            $itc_dir_2->itcfaxnumb = $r->fax_number_2_itc;

            $itc_dir_2->itcmail = $r->mail_2_itc;

            $itc_dir_1->save();
            $itc_dir_2->save();

        }

        do_log('Realizó Mantenimiento del cliente ( number:' . strip_tags($customer->getCode()) . ' )');

        $idn = session('customer_maintenance');

        session()->forget('customer_maintenance');
        session()->forget('customer_maintenance_core');

        if (config('bame.mantenance_need_approvals') == 'true') {
            if ($r->core == 'ibs') {
                return redirect()->route('customer.maintenance.create', array_merge($r->only(['tdc', 'core', '_token']), ['identification' => $idn, 'core' => 'itc']))->with('success', 'Los cambios fueron guardados correctamente, en espera de aprobación.')->with('link', route('customer.maintenance.print', $maintenance_ibs->id));
            } else if ($r->core == 'itc') {
                if (session('tdc_numbers')->count() == $customer->actives_creditcards->count()) {
                    session()->forget('tdc_numbers');

                    return redirect()->route('customer.maintenance.create')->with('success', 'Los cambios fueron guardados correctamente, en espera de aprobación.')->with('link', route('customer.maintenance.print', $maintenance_ibs->id));
                } else {
                    foreach ($customer->actives_creditcards as $index => $actives_creditcard) {
                        if (!session('tdc_numbers')->contains($actives_creditcard->getNumber())) {
                            return redirect()->route('customer.maintenance.create', array_merge($r->only(['tdc', 'core', '_token']), ['identification' => $idn, 'core' => 'itc', 'tdc' => $index]))->with('success', 'Los cambios fueron guardados correctamente, en espera de aprobación.')->with('link', route('customer.maintenance.print', $maintenance_ibs->id));
                        }
                    }
                }
            }
        } else {
            return redirect()->route('customer.maintenance.approve', ['ids' => $maintenance_ibs->id])->with('success', 'Los cambios fueron guardados y aprobados correctamente.')->with('link', route('customer.maintenance.print', $maintenance_ibs->id));
        }
    }

    public function approve(Request $request)
    {
        if (can_not_do('customer_approvals_address')) {
            return redirect(route('customer.maintenance.create'))->with('error', 'Usted no tiene los permisos necesarios para aprobar los mantenimientos.');
        }

        $datetime = new Datetime();

        $ids = explode(',', $request->ids);

        $maintenances = MaintenanceIbs::whereIn('id', $ids)->get();

        foreach ($maintenances as $maintenance) {
            $customer = Customer::SearchByIdentification($maintenance->cliident)->first();

            if ($maintenance->typecore == 'ibs') {
                $customer->cusna2 = $maintenance->ibsstreet;
                $customer->cusna4 = $maintenance->ibsbuhounu;
                $customer->cusctr = $maintenance->ibscountry;
                $customer->cusste = $maintenance->ibsprovinc;
                $customer->cusuc8 = $maintenance->ibscityc;
                $customer->cusuc7 = $maintenance->ibssectorc;
                $customer->cuspob = $maintenance->ibsposmail;
                $customer->cuszpc = $maintenance->ibszipcode;
                $customer->cusiad = $maintenance->ibsmail;
                $customer->cushpn = $maintenance->ibshouphon;
                $customer->cusphn = $maintenance->ibsoffipho;
                $customer->cusfax = $maintenance->ibsfaxphon;
                $customer->cusph1 = $maintenance->ibsmovipho;

                $customer->save();
            }

            if ($maintenance->typecore == 'itc') {

                $this->save_address_one($maintenance, $customer, $datetime);

                $this->save_address_two($maintenance, $customer, $datetime);

            }

            $maintenance->isapprov = true;
            $maintenance->approvby = session()->get('user');
            $maintenance->approvname = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
            $maintenance->approvdate = $datetime->format('Y-m-d H:i:s');

            $maintenance->updated_by = $maintenance->approvby;
            $maintenance->updatename = $maintenance->approvname;
            $maintenance->updated_at = $maintenance->approvdate;

            $maintenance->save();

            do_log('Realizó Mantenimiento del cliente ( numero:' . strip_tags($customer->getCode()) . ' )');
        }

        if (!$request->to_approver) {
            $msg = 'Los cambios fueron guardados correctamente';

            if (config('bame.mantenance_need_approvals') == 'true') {
                $msg .= ', en espera de aprobación';
            }

            $msg .= '.';

            if ($maintenance->typecore == 'ibs') {
                return redirect()->route('customer.maintenance.create', array_merge($request->only(['tdc', 'core', '_token']), ['identification' => $maintenance->cliident, 'core' => 'itc']))->with('success', $msg);
            } else if ($maintenance->typecore == 'itc') {
                if (session('tdc_numbers')->count() == $customer->actives_creditcards->count()) {
                    session()->forget('tdc_numbers');

                    return redirect()->route('customer.maintenance.create')->with('success', $msg);
                } else {
                    foreach ($customer->actives_creditcards as $index => $actives_creditcard) {
                        if (!session('tdc_numbers')->contains($actives_creditcard->getNumber())) {
                            return redirect()->route('customer.maintenance.create', array_merge($request->only(['tdc', 'core', '_token']), ['identification' => $maintenance->cliident, 'core' => 'itc', 'tdc' => $index]))->with('success', 'Los cambios fueron guardados correctamente, en espera de aprobación.');
                        }
                    }
                }
            }
        }

        return redirect()->route('customer.maintenance.index')->with('success', 'Los cambios fueron guardados y aprobados correctamente.');
    }

    protected function getCode($value)
    {
        $parts = explode('|', $value);

        return count($parts) > 0 ? $parts[0] : '';
        // return explode('|', $value)[0];
    }

    protected function getDesc($value)
    {
        $parts = explode('|', $value);

        return count($parts) > 1 ? $parts[1] : '';
        // return explode('|', $value)[1];
    }

    protected function load(Request $request)
    {
        $ibs_query = DB::connection('ibs')->table('cnofc')->select('cnorcd code, cnodsc description')->orderBy('description');

        if ($request->search == 'province_ibs') {
            return $ibs_query->where('cnocfl', 'PV')->get();
        }

        if ($request->search == 'city_ibs') {
            if ($this->getCode($request->country) == 'DR') {
                $ibs_query->where('cnomid', $this->getCode($request->province));
            }

            return $ibs_query->where('cnocfl', 'PI')->get();
        }

        if ($request->search == 'sector_ibs') {
            if ($this->getCode($request->country == 'DR')){
                $ibs_query->where('cnomid', $this->getCode($request->province));
                $ibs_query->where('cnomic', $this->getCode($request->city));
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
            $and_where = "AND PROVI_RELD = {$this->getCode($request->province)}";
            $group_by = $field_rel;
        }

        if ($request->search == 'municipality') {
            $field_rel = 'MUNIC_RELD';
            $field_code = "MUNIC_TMUN";
            $field_description = "DESMC_TMUN";
            $table = "SASTMUN00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$this->getCode($request->province)} AND CIUDA_RELD = {$this->getCode($request->city)}";
            $group_by = $field_rel;
        }

        if ($request->search == 'sector') {
            $field_rel = 'SECTO_RELD';
            $field_code = "SECTO_TDSE";
            $field_description = "DESSE_TDSE";
            $table = "SASTDSE00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$this->getCode($request->province)} AND CIUDA_RELD = {$this->getCode($request->city)} AND MUNIC_RELD = {$this->getCode($request->municipality)}";
            $group_by = $field_rel;
        }

        if ($request->search == 'neighborhood') {
            $field_rel = 'BARRI_RELD';
            $field_code = "BARRI_TDBA";
            $field_description = "DESBA_TDBA";
            $table = "SASTDBA00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$this->getCode($request->province)} AND CIUDA_RELD = {$this->getCode($request->city)} AND MUNIC_RELD = {$this->getCode($request->municipality)} AND SECTO_RELD = {$this->getCode($request->sector)}";
            $group_by = $field_rel;
        }

        if ($request->search == 'street') {
            $field_rel = 'CALLE_RELD';
            $field_code = "CALLE_TDCA";
            $field_description = "DESCA_TDCA";
            $table = "SASTDCA00";

            $sql_search .= $field_rel;
            $and_where = "AND PROVI_RELD = {$this->getCode($request->province)} AND CIUDA_RELD = {$this->getCode($request->city)} AND MUNIC_RELD = {$this->getCode($request->municipality)} AND SECTO_RELD = {$this->getCode($request->sector)} AND BARRI_RELD = {$this->getCode($request->neighborhood)}";
            $group_by = $field_rel;
        }

        $sql_search .= " IDS FROM SASRELD00 WHERE CODPA_RELD = '{$this->getCode($request->country)}' AND REGIO_RELD = '{$this->getCode($request->region)}' {$and_where} GROUP BY {$group_by}";
        $ids = collect(DB::connection('itc')->select($sql_search))->implode('ids', ',');
        $ids = empty($ids) ? '0' : $ids;

        $sql = "SELECT TRIM({$field_code}) code, TRIM({$field_description}) description FROM {$table} WHERE {$field_code} IN ({$ids}) ORDER BY {$field_description}";
        $result = collect(DB::connection('itc')->select($sql));

        return $result;
    }

    private function save_address_one($maintenance, $customer, $datetime)
    {
        $d = $maintenance->itc_dir_one;

        if (!$d->itcregionc) {
            return false;
        }

        $tdc_numbers = explode(',', $maintenance->tdcnumber);

        foreach ($tdc_numbers as $key => $value) {
            $address = [
                'CODBA_MDIR' => 1, //Codigo Banco
                'CODCI_MDIR' => 1, //Cod. Cia a Procesar
                'NUSOL_MDIR' => 0, //Numero Solicitud
                'TCACT_MDIR' => $value, //Numero de Tarjeta
                'CODCL_MDIR' => $maintenance->clinumber, //Codigo Cliente
                'IDDIR_MDIR' => 1, //Tipo Direccion
                'FOREE_MDIR' => $d->waysendsta, //Forma Envio Estado
                'SECTP_MDIR' => 0, //Secuencia Tipo/Direc
                'CIFCL_MDIR' => '', //LLave Cif Cliente
                'CODPA_MDIR' => $d->itccountrc, //Codigo Pais
                'REGIO_MDIR' => $d->itcregionc, //Codigo Region
                'PROVI_MDIR' => $d->itcprovinc, //Codigo Provincia
                'CIUCL_MDIR' => $d->itccityc, //Codigo Ciudad
                'MUNIC_MDIR' => $d->itcmunicic, //Codigo Municipio
                'SECTR_MDIR' => $d->itcsectorc, //Codigo Sector
                'BARRI_MDIR' => $d->itcneighoc, //Codigo Barrio
                'CALCL_MDIR' => $d->itcstreetc, //Codigo Calles
                'EDIFC_MDIR' => $d->itcbuiname, //Nombre Edificio
                'MANZC_MDIR' => $d->itcblock, //Codigo Manzana
                'NUMCA_MDIR' => $d->itchousnum, //No. Casa/Apartamento
                'KILOM_MDIR' => $d->itckm, //Kilometro Si es Carr
                'CALL1_MDIR' => $d->itcinstre1, //Entre Cuales Calle 1
                'CALL2_MDIR' => $d->itcinstre2, //Entre Cuales Calle 2
                'INSTD_MDIR' => $d->itcspeinst, //Instruccion Especial
                'ZONAP_MDIR' => $d->itcposzone, //Zona Postal
                'APOST_MDIR' => $d->itcposmail, //Apartado Postal
                'IDTEP_MDIR' => 0, //Codigo Pais
                'AREAP_MDIR' => $d->itcmphoare, //Area Telefono
                'NUTEP_MDIR' => $d->itcmphonum, //Numero Telefono
                'EXTEP_MDIR' => $d->itcmphoext, //Extension Telefono
                'IDTES_MDIR' => 0, //Codigo Pais
                'AREAS_MDIR' => $d->itcsphoare, //Area Telefono
                'NUTES_MDIR' => $d->itcsphonum, //Numero Telefono
                'EXTES_MDIR' => $d->itcsphoext, //Extension Telefono
                'IDTCP_MDIR' => 0, //Codigo Pais
                'ARECP_MDIR' => $d->itcmcelare, //Area Telefono
                'NUTCP_MDIR' => $d->itcmcelnum, //Numero Telefono
                'IDTCS_MDIR' => 0, //Codigo Pais
                'ARECS_MDIR' => $d->itcscelare, //Area Telefono
                'NUTCS_MDIR' => $d->itcscelnum, //Numero Telefono
                'AREAF_MDIR' => $d->itcfaxarea, //Area Fax
                'NUMFX_MDIR' => $d->itcfaxnumb, //Numero de Fax
                'EMAIL_MDIR' => $d->itcmail, //Correo Electronico
                'STSDI_MDIR' => '', //Status Direccion
                'STSCA_MDIR' => '', //Status de Cambios
                // 'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                // 'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                // 'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                // 'USRMO_MDIR' => 1, //Usuario Modificacion
                // 'FECMO_MDIR' => 1, //Fecha Modificacion
                // 'HORMO_MDIR' => 1, //Hora Modificacion
            ];

            if ($customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_one) {
                $address = array_merge($address, [
                    'USRMO_MDIR' => 'BADINTRANE', //Usuario Modificacion
                    'FECMO_MDIR' => $datetime->format('Ymd'), //Fecha Modificacion
                    'HORMO_MDIR' => $datetime->format('His'), //Hora Modificacion
                ]);

                $customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_one()->update($address);
            } else {
                $address = array_merge($address, [
                    'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                    'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                    'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                ]);

                $customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_one()->insert($address);
            }
        }
    }

    private function save_address_two($maintenance, $customer, $datetime)
    {
        $d = $maintenance->itc_dir_two;

        if (!$d->itcregionc) {
            return false;
        }

        $tdc_numbers = explode(',', $maintenance->tdcnumber);

        foreach ($tdc_numbers as $key => $value) {
            $address = [
                'CODBA_MDIR' => 1, //Codigo Banco
                'CODCI_MDIR' => 1, //Cod. Cia a Procesar
                'NUSOL_MDIR' => 0, //Numero Solicitud
                'TCACT_MDIR' => $value, //Numero de Tarjeta
                'CODCL_MDIR' => $maintenance->clinumber, //Codigo Cliente
                'IDDIR_MDIR' => 2, //Tipo Direccion
                'FOREE_MDIR' => $d->waysendsta, //Forma Envio Estado
                'SECTP_MDIR' => 0, //Secuencia Tipo/Direc
                'CIFCL_MDIR' => '', //LLave Cif Cliente
                'CODPA_MDIR' => $d->itccountrc, //Codigo Pais
                'REGIO_MDIR' => $d->itcregionc, //Codigo Region
                'PROVI_MDIR' => $d->itcprovinc, //Codigo Provincia
                'CIUCL_MDIR' => $d->itccityc, //Codigo Ciudad
                'MUNIC_MDIR' => $d->itcmunicic, //Codigo Municipio
                'SECTR_MDIR' => $d->itcsectorc, //Codigo Sector
                'BARRI_MDIR' => $d->itcneighoc, //Codigo Barrio
                'CALCL_MDIR' => $d->itcstreetc, //Codigo Calles
                'EDIFC_MDIR' => $d->itcbuiname, //Nombre Edificio
                'MANZC_MDIR' => $d->itcblock, //Codigo Manzana
                'NUMCA_MDIR' => $d->itchousnum, //No. Casa/Apartamento
                'KILOM_MDIR' => $d->itckm, //Kilometro Si es Carr
                'CALL1_MDIR' => $d->itcinstre1, //Entre Cuales Calle 1
                'CALL2_MDIR' => $d->itcinstre2, //Entre Cuales Calle 2
                'INSTD_MDIR' => $d->itcspeinst, //Instruccion Especial
                'ZONAP_MDIR' => $d->itcposzone, //Zona Postal
                'APOST_MDIR' => $d->itcposmail, //Apartado Postal
                'IDTEP_MDIR' => 0, //Codigo Pais
                'AREAP_MDIR' => $d->itcmphoare, //Area Telefono
                'NUTEP_MDIR' => $d->itcmphonum, //Numero Telefono
                'EXTEP_MDIR' => $d->itcmphoext, //Extension Telefono
                'IDTES_MDIR' => 0, //Codigo Pais
                'AREAS_MDIR' => $d->itcsphoare, //Area Telefono
                'NUTES_MDIR' => $d->itcsphonum, //Numero Telefono
                'EXTES_MDIR' => $d->itcsphoext, //Extension Telefono
                'IDTCP_MDIR' => 0, //Codigo Pais
                'ARECP_MDIR' => $d->itcmcelare, //Area Telefono
                'NUTCP_MDIR' => $d->itcmcelnum, //Numero Telefono
                'IDTCS_MDIR' => 0, //Codigo Pais
                'ARECS_MDIR' => $d->itcscelare, //Area Telefono
                'NUTCS_MDIR' => $d->itcscelnum, //Numero Telefono
                'AREAF_MDIR' => $d->itcfaxarea, //Area Fax
                'NUMFX_MDIR' => $d->itcfaxnumb, //Numero de Fax
                'EMAIL_MDIR' => $d->itcmail, //Correo Electronico
                'STSDI_MDIR' => '', //Status Direccion
                'STSCA_MDIR' => '', //Status de Cambios
                // 'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                // 'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                // 'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                // 'USRMO_MDIR' => 1, //Usuario Modificacion
                // 'FECMO_MDIR' => 1, //Fecha Modificacion
                // 'HORMO_MDIR' => 1, //Hora Modificacion
            ];

            if ($customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_two) {
                $address = array_merge($address, [
                    'USRMO_MDIR' => 'BADINTRANE', //Usuario Modificacion
                    'FECMO_MDIR' => $datetime->format('Ymd'), //Fecha Modificacion
                    'HORMO_MDIR' => $datetime->format('His'), //Hora Modificacion
                ]);

                $customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_two()->update($address);
            } else {
                $address = array_merge($address, [
                    'USRDI_MDIR' => 'BADINTRANE', //Usuario Digitacion
                    'FECDI_MDIR' => $datetime->format('Ymd'), //Fecha Digitacion
                    'HORDI_MDIR' => $datetime->format('His'), //Hora Digitacion
                ]);

                $customer->actives_creditcards->where('tcact_mtar', $value)->first()->address_two()->insert($address);
            }
        }
    }

    public function excel(Request $request)
    {
        $maintenances = MaintenanceIbs::lastest();

        if ($request->term) {
            $term = cap_str($request->term);

            $maintenances = $maintenances->orWhere('clinumber', 'like', '%' . $term . '%')
                        ->orWhere('cliident', 'like', '%' . $term . '%')
                        ->orWhere('tdcnumber', 'like', '%' . $term . '%');
        }

        if ($request->pending_approval) {
            $maintenances->where('isapprov', false);
        }

        if ($request->date_from) {
            $maintenances->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $maintenances->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $maintenances = $maintenances->get();

        return view('customer.maintenance.excel.maintenances')
                ->with('maintenances', $maintenances);
    }

    public function print($id)
    {
        $m = MaintenanceIbs::find($id);

        if ($m->isapprov) {
            return back()->with('error', 'Este mantenimiento ha sido aprobado, no es posible imprimirlo.');
        }

        do_log('Imprimió el Mantenimiento ( cliente:' . strip_tags($m->clinumber) . ' )');

        return view('customer.maintenance.print.maintenance')
            ->with('datetime', new DateTime)
            ->with('m', $m);
    }
}
