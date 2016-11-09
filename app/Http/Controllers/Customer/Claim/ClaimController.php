<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Models\Customer\Customer;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\CtDc\CtDc;
use Bame\Models\Customer\Claim;
use Bame\Http\Requests\Customer\Claim\ClaimRequest;

class ClaimController extends Controller
{
    public function index()
    {
        $ct_dc = CtDc::all();

        $claim_types = $ct_dc->where('type', 'CT');
        $distribution_channels = $ct_dc->where('type', 'DC');

        return view('customer.claim.index')
            ->with('claim_types', $claim_types)
            ->with('distribution_channels', $distribution_channels);
    }

    public function create(Request $request)
    {
        $ct_dc = CtDc::where('is_active', true)->get();

        $claim_types = $ct_dc->where('type', 'CT');
        $distribution_channels = $ct_dc->where('type', 'DC');

        $view = view('customer.claim.create');

        if ($request->identification) {

            $this->validate($request, [
                'identification' => 'required|alpha_num|max:15',
            ]);

            $identification = $request->identification;

            $customer = Customer::where('cusidn', $identification)->orWhere('cusln3', $identification)->first();

            if (!$customer) {
                return redirect(route('customer.claim.create'))->with('warning', 'La información suministrada no corresponde a ningún cliente en IBS.');
            }

            session()->put('customer_claim', $customer);
        }

        return $view
            ->with('claim_types', $claim_types)
            ->with('distribution_channels', $distribution_channels);
    }

    public function store(ClaimRequest $request)
    {
        $claim = new Claim;

        $customer = session()->get('customer_claim');

        $claim->id = uniqid(true);
        $claim->customer_number = $customer->getCode();
        $claim->names = $customer->getNames();
        $claim->last_names = $customer->getLastNames();
        $claim->is_company = $customer->isCompany();
        $claim->identification = $customer->getDocument();
        $claim->passport = $customer->getPassport();
        $claim->legal_name = $customer->getLegalName();
        $claim->residential_phone = $customer->getResidentialPhone();
        $claim->office_phone = $customer->getOfficePhone();
        $claim->cell_phone = $customer->getCellPhone();
        $claim->fax_phone = $customer->getFaxPhone();
        $claim->mail = $customer->getMail();
        $claim->street_address = $customer->getStreet();
        $claim->street_number = null;
        $claim->sector_address = null;
        $claim->building_number = $customer->getHouse();
        $claim->apartment_number = $customer->getBuilding();
        $claim->city = null;
        $claim->province = null;
        $claim->is_closed = false;
        $claim->currency = $request->currency;
        $claim->amount = round($request->amount, 2);

        $claim_type = CtDc::find($request->claim_type);

        if (!$claim_type) {
            return back()->with('error', 'El Tipo de Reclamación seleccionado no existe!');
        }

        $claim->claim_type = $claim_type->description;
        $claim->response_term = $request->response_term;
        $claim->response_place = get_offices($request->office);
        $claim->response_date = $request->response_date;
        $claim->observations = $request->observations;
        $claim->rate_day = 0.00;
        $claim->is_signed = false;

        $distribution_channel = CtDc::find($request->channel);

        if (!$distribution_channel) {
            return back()->with('error', 'El Canal de Distribución seleccionado no existe!');
        }

        $claim->distribution_channel = $distribution_channel->description;
        $claim->product_type = get_product_types($request->product_type);

        $product_parts = explode('|', $request->product);

        if (count($product_parts) == 3) {
            $product_number = $customer->creditcards->get($product_parts[0])->getNumber();
            $product_code = $product_parts[1];
        } else {
            $product_number = $product_parts[1];
            $product_code = $product_parts[0];
        }

        $claim->product_number = $product_number;
        $claim->product_code = $product_code;

        $claim->created_by = session()->get('user');
        $claim->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $last_claim = Claim::orderBy('created_at', 'desc')
                            ->where('created_at', (new DateTime)->format('Y-m-d'))->first();

        $last_claim_number = $last_claim ? $last_claim->claim_number : null;

        $claim->claim_number = get_next_claim_number($last_claim_number);
        $claim->save();
    }

    public function destroy()
    {
        session()->forget('customer_claim');

        return redirect(route('customer.claim.create'))->with('success', 'La reclamación ha sido cancelada correctamente.');
    }
}
