<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Models\Customer\Customer;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\Claim\CtDc;
use Bame\Models\Customer\Claim\Claim;
use Bame\Http\Requests\Customer\Claim\ClaimRequest;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::orderBy('claim_number', 'desc')->paginate();
        $ct_dc = CtDc::all();

        $claim_types = $ct_dc->where('type', 'CT');
        $distribution_channels = $ct_dc->where('type', 'DC');

        return view('customer.claim.index')
            ->with('claims', $claims)
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
        $messages = $this->validate_field($request);

        if ($messages->count()) {
            $request->session()->flash('messages_claim', $messages->values());
            return back()->withInput();
        }

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
        $claim->sector_address = $customer->getSector();
        $claim->building_residential = $customer->getResidentialOrBuilding();
        $claim->apartment_number = $customer->getBuildingOrHouseNumber();
        $claim->city = $customer->getCity();
        $claim->province = $customer->getProvince();
        $claim->is_closed = false;
        $claim->currency = $request->currency;
        $claim->amount = round($request->amount, 2);

        $claim_type = CtDc::find($request->claim_type);

        if (!$claim_type) {
            return back()->with('error', 'El Tipo de Reclamación seleccionado no existe!');
        }

        $claim->claim_type = $claim_type->description;

        if (!in_array($request->response_term, get_response_term())) {
            return back()->with('error', 'El Plazo de Respuesta seleccionado no existe!');
        }

        $claim->response_term = $request->response_term;
        $claim->response_place = get_offices($request->office);
        $claim->response_date = (new DateTime)->modify('+' . $request->response_term . ' days');
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

        if ($customer->isCompany()) {
            $claim->agent_legal_name = $customer->agent->getLegalName();
            $claim->agent_identification = $customer->agent->getIdentification();
            $claim->agent_residential_phone = $request->residential_phone;
            $claim->agent_office_phone = $request->office_phone;
            $claim->agent_cell_phone = $customer->agent->getPhoneNumber();
            $claim->agent_mail = $request->mail;
            $claim->agent_fax_phone = $request->fax;
        }

        $claim->created_by = session()->get('user');
        $claim->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $last_claim = Claim::orderBy('created_at', 'desc')->first();

        $last_claim_number = $last_claim ? $last_claim->claim_number : null;

        $claim->claim_number = get_next_claim_number($last_claim_number);
        $claim->save();

        session()->forget('customer_claim');

        return redirect(route('customer.claim.index'))->with('success', 'La reclamación ha sido creada correctamente.');
    }

    public function destroy()
    {
        session()->forget('customer_claim');

        return redirect(route('customer.claim.create'))->with('success', 'La reclamación ha sido cancelada correctamente.');
    }

    protected function validate_field($request)
    {
        $customer = session()->get('customer_claim');

        $messages = collect();

        if ($customer->isCompany()) {
            if (empty($customer->agent->getLegalName())) {
                $messages->push('El nmbre legal del representante es requerido.');
            }

            if (empty(clear_str($request->residential_phone)) && empty(clear_str($request->office_phone)) && empty(clear_str($customer->agent->getPhoneNumber()))) {
                $messages->push('El representante debe tener un teléfono residencial, oficina o celular.');
            }

            if (empty(clear_str($request->mail))) {
                $messages->push('El representante debe tener un correo.');
            }
        } else {
            if (empty(clear_str($customer->getNames())) || empty(clear_str($customer->getLastNames()))) {
                $messages->push('Los campos Nombres y Apellidos son requeridos.');
            }

            if (empty($customer->getMail())) {
                $messages->push('El cliente debe tener un correo.');
            }
        }

        if (empty($customer->getDocument()) && empty($customer->getPassport())) {
            $messages->push('El cliente debe tener al menos una identificación.');
        }

        if (clear_str($customer->getResidentialPhone()) == '(0) ' || clear_str($customer->getCellPhone()) == '(0) ') {
            $messages->push('El cliente debe tener un teléfono residencial o celular.');
        }

        return $messages;
    }
}
