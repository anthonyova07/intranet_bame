<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Models\Customer\Customer;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\Claim\Param;
use Bame\Models\Customer\Claim\Claim;
use Bame\Http\Requests\Customer\Claim\ClaimRequest;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $claims = Claim::orderBy('created_at', 'desc');

        if ($request->term) {
            $term = cap_str($request->term);

            $claims = $claims->orWhere('claim_number', 'like', '%' . $term . '%')
                        ->orWhere('customer_number', 'like', '%' . $term . '%')
                        ->orWhere('names', 'like', '%' . $term . '%')
                        ->orWhere('last_names', 'like', '%' . $term . '%')
                        ->orWhere('identification', 'like', '%' . $term . '%')
                        ->orWhere('passport', 'like', '%' . $term . '%')
                        ->orWhere('passport', 'like', '%' . $term . '%')
                        ->orWhere('legal_name', 'like', '%' . $term . '%')
                        ->orWhere('residential_phone', 'like', '%' . $term . '%')
                        ->orWhere('office_phone', 'like', '%' . $term . '%')
                        ->orWhere('cell_phone', 'like', '%' . $term . '%')
                        ->orWhere('fax_phone', 'like', '%' . $term . '%')
                        ->orWhere('mail', 'like', '%' . $term . '%')
                        ->orWhere('amount', 'like', '%' . $term . '%')
                        ->orWhere('claim_type', 'like', '%' . $term . '%')
                        ->orWhere('observations', 'like', '%' . $term . '%')
                        ->orWhere('rate_day', 'like', '%' . $term . '%')
                        ->orWhere('distribution_channel', 'like', '%' . $term . '%')
                        ->orWhere('product_type', 'like', '%' . $term . '%')
                        ->orWhere('product_number', 'like', '%' . $term . '%')
                        ->orWhere('product_code', 'like', '%' . $term . '%');
        }

        if ($request->date_from) {
            $claims->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->date_to) {
            $claims->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $claims = $claims->paginate();

        $param = Param::all();

        $claim_types = $param->where('type', 'CT');
        $claim_types_visa = $param->where('type', 'TDC');
        $distribution_channels = $param->where('type', 'DC');
        $kind_persons = $param->where('type', 'KP');

        return view('customer.claim.index')
            ->with('claims', $claims)
            ->with('claim_types', $claim_types)
            ->with('claim_types_visa', $claim_types_visa)
            ->with('distribution_channels', $distribution_channels)
            ->with('kind_persons', $kind_persons);
    }

    public function create(Request $request)
    {
        $param = Param::activeOnly()->get();

        $claim_types = $param->where('type', 'CT');
        $distribution_channels = $param->where('type', 'DC');
        $kind_persons = $param->where('type', 'KP');

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
            ->with('distribution_channels', $distribution_channels)
            ->with('kind_persons', $kind_persons);
    }

    public function store(ClaimRequest $request)
    {
        $messages = $this->validate_fields($request);

        $product_parts = explode('|', $request->product);

        if (in_array($request->product_type, ['TARCRE', 'TARDEB'])) {
            if ($request->form_type == 'NIN' || count($product_parts) < 3) {
                $messages->push('Debe seleccionar un tipo de formulario o un producto de tarjeta de crédito.');
            }
        }

        if (in_array($request->product_type, ['PRECOM', 'PRECON', 'PREHIP'])) {
            if ($request->form_type != 'CAI' || $product_parts[0][0] != 'P') {
                $messages->push('Debe seleccionar un formulario de ' . get_form_types('CAI') . ' o un producto de préstamo.');
            }
        }

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

        $claim_type = Param::find($request->claim_type);

        if (!$claim_type) {
            return back()->with('error', 'El Tipo de Reclamación seleccionado no existe!');
        }

        $claim->claim_type_code = $claim_type->code;
        $claim->claim_type_description = $claim_type->description;

        $claim->claim_result = 'P';

        if (!in_array($request->response_term, get_response_term())) {
            return back()->with('error', 'El Plazo de Respuesta seleccionado no existe!');
        }

        $claim->response_term = $request->response_term;
        $claim->response_place = get_offices($request->office);
        $claim->response_date = (new DateTime)->modify('+' . $request->response_term . ' days');
        $claim->observations = $request->observations;
        $claim->rate_day = 0.00;
        $claim->is_signed = false;

        $kind_person = Param::find($request->kind_person);

        if (!$kind_person) {
            return back()->with('error', 'El Tipo de Persona seleccionado no existe!');
        }

        $claim->kind_person_code = $kind_person->code;
        $claim->kind_person_description = $kind_person->description;

        $distribution_channel = Param::find($request->channel);

        if (!$distribution_channel) {
            return back()->with('error', 'El Canal de Distribución seleccionado no existe!');
        }

        $claim->distribution_channel = $distribution_channel->description;
        $claim->product_type = get_product_types($request->product_type);

        if (count($product_parts) == 3) {
            $product_number = $customer->creditcards->get($product_parts[0])->getNumber();
            $product_code = $product_parts[1];
        } else {
            $product_number = $product_parts[1];
            $product_code = $product_parts[0];
        }

        $claim->product_number = $product_number;
        $claim->product_code = $product_code;
        $claim->product_intranet = $request->product_type;

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

        if (in_array($request->form_type, ['CON', 'FRA', 'CAI'])) {
            return redirect(route('customer.claim.{claim_id}.{form_type}.form.create', ['claim_id' => $claim->id, 'form_type' => $request->form_type]))
                    ->with('success', 'La reclamación ha sido creada correctamente.')
                    ->with('info', 'Ahora debe completar el Formulario de ' . get_form_types($request->form_type) . '.');
        }

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación ha sido creada correctamente.');
    }

    public function show($id)
    {
        $claim = Claim::find($id);

        return view('customer.claim.show')
            ->with('claim', $claim);
    }

    public function destroy()
    {
        session()->forget('customer_claim');

        return redirect(route('customer.claim.create'))->with('success', 'La reclamación ha sido cancelada correctamente.');
    }

    public function getApprove(Request $request, $claim_id, $to_approve)
    {
        $to_approve = boolval($to_approve);

        $claim = Claim::find($claim_id);

        if ($claim->is_approved == 1) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('info', 'La reclamación ya ha sido Aprobada/Rechazada anteriormente.');
        }

        return view('customer.claim.approve')
            ->with('to_approve', $to_approve)
            ->with('claim', $claim);
    }

    public function postApprove(Request $request, $claim_id, $to_approve)
    {
        $this->validate($request, [
            'comment' => 'required|max:500',
        ]);

        $to_approve = boolval($to_approve);

        $claim = Claim::find($claim_id);

        if ($claim->is_approved == 1 || can_not_do('customer_claim_approve')) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('warning', 'La reclamación ya ha sido Aprobada/Rechazada anteriormente o no tiene los permisos requeridos.');
        }

        $claim->is_approved = $to_approve;
        $claim->approved_by = session()->get('user');
        $claim->approved_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $claim->approved_comments = $request->comment;
        $claim->approved_date = new DateTime;

        $claim->proceed_credit = $request->proceed_credit ? true : false;

        $claim->save();

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación ha sido aprobada correctamente.');
    }

    public function getComplete(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);

        if ($claim->is_closed) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('info', 'La reclamación ya ha sido Terminada anteriormente.');
        }

        return view('customer.claim.complete')
            ->with('claim', $claim);
    }

    public function postComplete(Request $request, $claim_id)
    {
        $this->validate($request, [
            'comment' => 'required|max:500',
            'rate_day' => 'numeric',
        ]);

        $claim = Claim::find($claim_id);

        if ($claim->is_closed || can_not_do('customer_claim_reject')) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('warning', 'La reclamación ya ha sido Terminada anteriormente o no tiene los permisos requeridos.');
        }

        $claim->is_closed = true;
        $claim->closed_by = session()->get('user');
        $claim->closed_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $claim->closed_comments = $request->comment;
        $claim->closed_date = new DateTime;

        $claim->claim_result = $request->claim_result ? 'F' : 'D';

        $claim->rate_day = $request->rate_day;

        $claim->save();

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación ha sido terminada correctamente.');
    }

    protected function validate_fields($request)
    {
        $customer = session()->get('customer_claim');

        $messages = collect();

        if ($customer->isCompany()) {
            if (empty($customer->getLegalName())) {
                $messages->push('La razón social de la empresa es requerido.');
            }

            if (empty($customer->agent->getLegalName())) {
                $messages->push('El nombre legal del representante es requerido.');
            }

            if (empty($customer->agent->getIdentification())) {
                $messages->push('La identificación del representante es requerido.');
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
