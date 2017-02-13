<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use DateTime;
use Bame\Http\Requests;
use Bame\Models\Customer\Customer;
use Bame\Http\Controllers\Controller;
use Bame\Models\Customer\Claim\Param;
use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\Status;
use Bame\Models\Customer\Claim\Attach;
use Bame\Models\Notification\Notification;
use Bame\Http\Requests\Customer\Claim\ClaimRequest;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        if (can_not_do('customer_claim_close')) {
            $claims = Claim::orderBy('created_at', 'desc');
        } else {
            $claims = Claim::orderBy('approved_date', 'desc');
        }

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
                        ->orWhere('type_code', 'like', '%' . $term . '%')
                        ->orWhere('type_description', 'like', '%' . $term . '%')
                        ->orWhere('observations', 'like', '%' . $term . '%')
                        ->orWhere('rate_day', 'like', '%' . $term . '%')
                        ->orWhere('distribution_channel_code', 'like', '%' . $term . '%')
                        ->orWhere('distribution_channel_description', 'like', '%' . $term . '%')
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

        if (!can_not_do('customer_claim_close')) {
            $claims->where('is_approved', true);
        }

        $claims = $claims->paginate();

        $param = Param::all();

        $claim_types = $param->where('type', 'CT');
        $claim_types_visa = $param->where('type', 'TDC');
        $distribution_channels = $param->where('type', 'DC');
        $kind_persons = $param->where('type', 'KP');
        $claim_statuses = $param->where('type', 'CS');
        $products_services = $param->where('type', 'PS');

        return view('customer.claim.index')
            ->with('claims', $claims)
            ->with('claim_types', $claim_types)
            ->with('claim_types_visa', $claim_types_visa)
            ->with('distribution_channels', $distribution_channels)
            ->with('kind_persons', $kind_persons)
            ->with('claim_statuses', $claim_statuses)
            ->with('products_services', $products_services);
    }

    public function create(Request $request)
    {
        $param = Param::activeOnly()->orderByDescription()->get();

        $claim_types = $param->where('type', 'CT');
        $distribution_channels = $param->where('type', 'DC');
        $kind_persons = $param->where('type', 'KP');
        $products_services = $param->where('type', 'PS');

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
            ->with('kind_persons', $kind_persons)
            ->with('products_services', $products_services);
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

        $claim->type_code = $claim_type->code;
        $claim->type_description = $claim_type->description;

        $claim->claim_result = 'P';

        if (!in_array($request->response_term, get_response_term())) {
            return back()->with('error', 'El Plazo de Respuesta seleccionado no existe!');
        }

        $claim->response_term = $request->response_term;
        $claim->response_place_code = $request->office;
        $claim->response_place_description = get_offices($request->office);
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

        $claim->distribution_channel_code = $distribution_channel->code;
        $claim->distribution_channel_description = $distribution_channel->description;

        $claim->product_type = get_product_types($request->product_type);

        $product_service = Param::find($request->product_service);

        if (!$product_service) {
            return back()->with('error', 'El Producto y Servicio seleccionado no existe!');
        }

        $claim->product_service_code = $product_service->code;
        $claim->product_service_description = $product_service->description;

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

        do_log('Creó la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

        Notification::notifyUsersByPermission('customer_claim_approve', 'Reclamaciones', 'Nueva reclamación creada (' . $claim->claim_number . ') pendiente de aprobación.', route('customer.claim.show', ['id' => $claim->id]));

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

        if (!$claim) {
            return redirect(route('customer.claim.index'));
        }

        do_log('Consultó la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

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
        $claim = Claim::find($claim_id);

        if ($to_approve == 'reopen') {
            $claim->is_approved = null;

            $claim->status_code = '';
            $claim->status_description = '';

            $claim->save();

            $noti = new Notification($claim->approved_by);
            $noti->create('Reclamaciones', 'La reclamación ' . $claim->claim_number . ' ha sido reabierta', route('customer.claim.show', ['id' => $claim->id]));
            $noti->save();

            $claim->createStatus('Reabierta', 'Reclamación Reabierta.');

            do_log('Reabrió la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

            return back()->with('info', 'La reclamación ha sido abierta nuevamente');
        }

        $to_approve = boolval($to_approve);

        if ($claim->is_approved == 1) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('info', 'La reclamación ya ha sido Aprobada/Rechazada anteriormente.');
        }

        $claim_statuses = Param::where('type', 'CS')->get();

        return view('customer.claim.approve')
            ->with('to_approve', $to_approve)
            ->with('claim_statuses', $claim_statuses)
            ->with('claim', $claim);
    }

    public function postApprove(Request $request, $claim_id, $to_approve)
    {
        $claim = Claim::find($claim_id);

        $to_approve = boolval($to_approve);

        $rules['comment'] = 'required|max:500';

        if ($to_approve == 0) {
            $rules['claim_status'] = 'required';
        }

        $rules['rate_day'] = 'min:1|numeric' . ($claim->currency == 'US$' ? '|required' : '');

        $this->validate($request, $rules);

        if ($claim->is_approved == 1 || can_not_do('customer_claim_approve')) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('warning', 'La reclamación ya ha sido Aprobada/Rechazada anteriormente o no tiene los permisos requeridos.');
        }

        $claim->is_approved = $to_approve;
        $claim->approved_by = session()->get('user');
        $claim->approved_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $claim->approved_comments = $request->comment;
        $claim->approved_date = new DateTime;

        $claim->rate_day = $request->rate_day;

        $claim->proceed_credit = $request->proceed_credit ? true : false;

        if ($to_approve == 0) {
            $claim_status = Param::find($request->claim_status);

            if (!$claim_status) {
                return back()->with('warning', 'El estatus de reclamación no existe.');
            }

            $claim->status_code = $claim_status->code;
            $claim->status_description = $claim_status->description;

            $claim->createStatus($claim_status, $request->comment);
        } else {
            $claim->createStatus('Aprobada', $request->comment);
        }

        $claim->save();

        $noti = new Notification($claim->created_by);
        $noti->create('Reclamaciones', 'La reclamación ' . $claim->claim_number . ' ha sido ' . ($to_approve ? 'Aprobada' : 'Rechazada'), route('customer.claim.show', ['id' => $claim->id]));
        $noti->save();

        if ($to_approve) {
            Notification::notifyUsersByPermission('customer_claim_close', 'Reclamaciones', 'Nueva reclamación creada y aprobada (' . $claim->claim_number . ') pendiente de trabajar.', route('customer.claim.show', ['id' => $claim->id]));
        }

        do_log(($to_approve ? 'Aprobó' : 'Rechazó') . ' la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación ha sido ' . ($to_approve ? 'Aprobada' : 'Rechazada') . ' correctamente.');
    }

    public function getClose(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);

        if ($claim->is_closed) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('info', 'La reclamación ya ha sido Terminada anteriormente.');
        }

        $claim_statuses = Param::where('type', 'CS')->get();

        return view('customer.claim.close')
            ->with('claim_statuses', $claim_statuses)
            ->with('claim', $claim);
    }

    public function postClose(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);

        $this->validate($request, [
            'claim_status' => 'required',
            'comment' => 'required|max:500',
        ]);

        if ($claim->is_closed || can_not_do('customer_claim_close')) {
            return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('warning', 'La reclamación ya ha sido Terminada anteriormente o no tiene los permisos requeridos.');
        }

        $claim_status = Param::find($request->claim_status);

        if (!$claim_status) {
            return back()->with('warning', 'El estatus de reclamación no existe.');
        }

        $claim->status_code = $claim_status->code;
        $claim->status_description = $claim_status->description;

        if ($request->claim_result != 'P') {
            $claim->is_closed = true;
            $claim->closed_by = session()->get('user');
            $claim->closed_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
            $claim->closed_comments = $request->comment;
            $claim->closed_date = new DateTime;
        }

        $claim->claim_result = $request->claim_result;

        $claim->save();

        $claim->createStatus($claim_status, $request->comment);

        $noti = new Notification($claim->created_by);
        $noti->create('Reclamaciones', 'La reclamación ' . $claim->claim_number . ' ha ' . ($request->claim_result == 'P' ? 'cambiado de estado' : 'sido cerrada.'), route('customer.claim.show', ['id' => $claim->id]));
        $noti->save();

        do_log(($request->claim_result == 'P' ? 'Cambió de Estado' : 'Cerró') . ' la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación ha ' . ($request->claim_result == 'P' ? 'cambiado de estado' : 'sido cerrada.') . ' correctamente.');
    }

    public function getAttach(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);

        if (!$claim) {
            return redirect(route('customer.claim.index'));
        }

        return view('customer.claim.attach')
            ->with('claim', $claim);
    }

    public function postAttach(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);

        if (!$claim) {
            return redirect(route('customer.claim.index'));
        }

        if ($claim->is_closed) {
            return back()->with('warning', 'La reclamación se encuentra cerrada.');
        }

        if ($request->hasFile('files')) {
            $files = collect($request->file('files'));

            $path = storage_path('app\\claims\\attaches\\' . $claim->id . '\\');

            $files->each(function ($file, $index) use ($path, $claim) {
                $file_name_destination = str_replace(' ', '_', $file->getClientOriginalName());

                $file_name_destination = remove_accents($file_name_destination);

                $file->move($path, $file_name_destination);

                $attach = new Attach;

                $attach->id = uniqid(true);
                $attach->claim_id = $claim->id;
                $attach->file = $file_name_destination;

                $attach->created_by = session()->get('user');
                $attach->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

                $attach->save();
            });

            do_log('Adjuntó archivos a la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

            Notification::notify('Reclamaciones', 'Nuevo/s documento/s adjunto a la reclamación ' . $claim->claim_number, route('customer.claim.show', ['id' => $claim->id]), $claim->created_by);
        }

        return back()->with('success', 'Los archivos han sido cargados correctamente.');
    }

    public function downloadAttach(Request $request, $claim_id, $attach)
    {
        $claim = Claim::find($claim_id);

        if (!$claim) {
            return redirect(route('customer.claim.index'));
        }

        $attach = $claim->attaches()->where('id', $attach)->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe!');
        }

        $path = storage_path('app\\claims\\attaches\\' . $claim->id . '\\' . $attach->file);

        do_log('Descargó archivo de la Reclamación ( número:' . strip_tags($claim->claim_number) . ' archivo:' . $attach->file . ' )');

        return response()->download($path);
    }

    public function deleteAttach(Request $request, $claim_id, $attach)
    {
        $claim = Claim::find($claim_id);

        if (!$claim) {
            return redirect(route('customer.claim.index'));
        }

        if ($claim->is_closed) {
            return back()->with('warning', 'La reclamación se encuentra cerrada.');
        }

        $attach = $claim->attaches()->where('id', $attach)->where('created_by', session()->get('user'))->first();

        if (!$attach) {
            return back()->with('warning', 'Este adjunto no existe o no fue cargado por usted!');
        }

        do_log('Eliminó archivo de la Reclamación ( número:' . strip_tags($claim->claim_number) . ' archivo:' . $attach->file . ' )');

        $attach->delete_attach();
        $attach->delete();

        return back()->with('success', 'El adjunto ha sido eliminado correctamente!');
    }

    public function statuses($id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return back()->with('warning', 'Esta reclamación no existe!');
        }

        $claim_statuses = Status::where('claim_id', $id)->lastestFirst()->get();

        do_log('Consultó los estatus de la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

        return view('customer.claim.statuses')
                ->with('claim', $claim)
                ->with('claim_statuses', $claim_statuses);
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

            // if (empty($customer->getMail())) {
            //     $messages->push('El cliente debe tener un correo.');
            // }
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
