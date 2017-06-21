<?php

namespace Bame\Http\Controllers\Customer;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use Bame\Models\Customer\Customer;
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

            $customer = Customer::with('creditcards')->SearchByIdentification($request->identification)->first();

            if (!$customer) {
                return redirect(route('customer.maintenance.create'))->with('warning', 'La información suministrada no corresponde a ningún cliente en IBS.');
            }

            session()->put('customer_maintenance', $customer);
        }

        $regions = Region::orderByDesc()->get();

        return view('customer.maintenance.create')
            ->with('regions', $regions)
            ->with('tdc', $request->tdc)
            ->with('core', $request->core)
            ->with('customer', session('customer_maintenance'));
    }

    public function store()
    {
        //
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
