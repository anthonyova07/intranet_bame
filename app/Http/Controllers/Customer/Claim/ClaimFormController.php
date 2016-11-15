<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\CtDc;
use Bame\Models\Customer\Product\CreditCardStatement;
use Bame\Models\Customer\Claim\Form\Form;
use Bame\Models\Customer\Claim\Form\Transaction;

class ClaimFormController extends Controller
{
    public function create(Request $request, $id, $form_type)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->form) {
            return redirect(route('customer.claim.form', ['id' => $claim->form->id]));
        }

        if (!session()->has('tdc_transactions_claim')) {
            $creditcard_statements = CreditCardStatement::byCreditcard($claim->product_number)->get();
            session()->put('tdc_transactions_claim', $creditcard_statements);
        }

        $claim_types_visa = CtDc::activeOnly()->visaOnly()->get();

        foreach ($claim_types_visa as $claim_type_visa) {

            $claim_type_visa->es_name = str_to_field($claim_type_visa->es_name, 'name_' . $claim_type_visa->id);
            $claim_type_visa->es_detail = str_to_field($claim_type_visa->es_detail, 'detail_' . $claim_type_visa->id);
            $claim_type_visa->es_detail_2 = str_to_field($claim_type_visa->es_detail_2, 'detail_2_' . $claim_type_visa->id);

        }

        return view('customer.claim.form.create')
                ->with('claim_types_visa', $claim_types_visa)
                ->with('form_type', $form_type)
                ->with('claim', $claim);
    }

    public function store(Request $request, $id, $form_type)
    {
        $claim = Claim::find($id);
        $claim_type_visa = CtDc::visaOnly()->find($request->claim_type_visa);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->form) {
            return redirect(route('customer.claim.form', ['id' => $claim->form->id]));
        }

        $fields_name = $request->input('fields_name_' . $request->claim_type_visa);
        $fields_detail = $request->input('fields_detail_' . $request->claim_type_visa);
        $fields_detail_2 = $request->input('fields_detail_2_' . $request->claim_type_visa);

        $fields = array_merge($fields_name ?? [], $fields_detail ?? [], $fields_detail_2 ?? []);

        $messages = $this->validate_fields($claim_type_visa, $fields, $request->transactions, $form_type);

        if ($messages->count()) {
            $request->session()->flash('messages_claim_form', $messages->values());
            return back();
        }

        $form = new Form;

        $form->id = uniqid(true);
        $form->claim_id = $claim->id;
        $form->form_type = $request->form_type;
        $form->principal_cardholder_name = $claim->names . ' ' . $claim->last_names;
        $form->cc_number = $claim->product_number;
        $form->cardholder_contact_number = $claim->getOnePhoneNumber();

        if ($form_type == 'CON') {
            $form->claim_es_name = field_to_str($claim_type_visa->es_name, $fields_name);
            $form->claim_es_detail = field_to_str($claim_type_visa->es_detail, $fields_detail);
            $form->claim_es_detail_2 = field_to_str($claim_type_visa->es_detail_2, $fields_detail_2);

            $form->claim_en_name = field_to_str($claim_type_visa->en_name, $fields_name);
            $form->claim_en_detail = field_to_str($claim_type_visa->en_detail, $fields_detail);
            $form->claim_en_detail_2 = field_to_str($claim_type_visa->en_detail_2, $fields_detail_2);
        }

        $form->response_date = $claim->response_date;

        $form->created_by = session()->get('user');
        $form->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $form->created_by_phone = session()->get('user_info')->getTelephoneNumber();

        $form->save();

        $transactions = collect();

        foreach ($request->transactions as $index) {
            $creditcard_statement = session()->get('tdc_transactions_claim')->get($index);

            $transaction = new Transaction;
            $transaction->id = uniqid(true);
            $transaction->form_id = $form->id;
            $transaction->form_type = $form_type;
            $transaction->transaction_date = $creditcard_statement->getFormatedDateTimeTransaction(true);
            $transaction->merchant_name = $creditcard_statement->getMerchantName();
            $transaction->country = $creditcard_statement->getCountry();
            $transaction->city = $creditcard_statement->getCity();
            $transaction->amount = $creditcard_statement->getAmount();

            $transactions->push($transaction);
        }

        $form->transactions()->saveMany($transactions->all());

        session()->forget('tdc_transactions_claim');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación de consumo ha sido creada correctamente.');
    }

    public function show($claim_id, $form_type, $id)
    {
        $form = Form::find($id);

        return view('customer.claim.form.show')
                ->with('form', $form);
    }

    public function validate_fields($claim_type_visa, $fields = [], $transactions = [], $form_type)
    {
        $messages = collect();

        if (!count($transactions) || !$transactions){
            $messages->push('Debe seleccionar al menos una transacción.');
        }

        if ($form_type == 'CON') {
            if ($claim_type_visa) {
                $fields_count = substr_count($claim_type_visa->es_name, '{field') +
                                    substr_count($claim_type_visa->es_detail, '{field') +
                                    substr_count($claim_type_visa->es_detail_2, '{field');

                if ($fields_count > 0) {
                    if (!count($fields)) {
                        $messages->push('Debe seleccionar un tipo de reclamación.');
                    } else {
                        foreach ($fields as $field) {
                            if (empty(clear_str($field))) {
                                $messages->push('Debe completar los campos indicados en el tipo de reclamación seleccionado.');
                                break;
                            }
                        }
                    }
                }
            } else {
                $messages->push('Debe seleccionar un tipo de reclamación.');
            }
        }

        return $messages;
    }
}
