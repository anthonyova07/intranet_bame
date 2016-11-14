<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\CtDc;
use Bame\Models\Customer\Product\CreditCardStatement;
use Bame\Models\Customer\Claim\Form\Consumption;
use Bame\Models\Customer\Claim\Form\Transaction;

class ClaimFormController extends Controller
{
    public function consumption(Request $request, $id)
    {
        $claim = Claim::find($id);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->consumption) {
            return redirect(route('customer.claim.consumption', ['id' => $claim->consumption->id]));
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

        return view('customer.claim.form.consumption.index')
                ->with('id', $id)
                ->with('claim_types_visa', $claim_types_visa)
                ->with('claim', $claim);
    }

    public function showConsumption($id)
    {
        $consumption = Consumption::find($id);

        return view('customer.claim.form.consumption.show')
                ->with('consumption', $consumption);
    }

    public function storeConsumption(Request $request, $id)
    {
        $claim = Claim::find($id);
        $claim_type_visa = CtDc::visaOnly()->find($request->claim_type_visa);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->consumption) {
            return redirect(route('customer.claim.consumption', ['id' => $claim->consumption->id]));
        }

        $fields_name = $request->input('fields_name_' . $request->claim_type_visa);
        $fields_detail = $request->input('fields_detail_' . $request->claim_type_visa);
        $fields_detail_2 = $request->input('fields_detail_2_' . $request->claim_type_visa);

        $fields = array_merge($fields_name ?? [], $fields_detail ?? [], $fields_detail_2 ?? []);

        $messages = $this->validate_fields($claim_type_visa, $fields, $request->transactions, $request->form_type);

        if ($messages->count()) {
            $request->session()->flash('messages_claim_consumption', $messages->values());
            return back();
        }

        $consumption = new Consumption;

        $consumption->id = uniqid(true);
        $consumption->claim_id = $claim->id;
        $consumption->principal_cardholder_name = $claim->names . ' ' . $claim->last_names;
        $consumption->cc_number = $claim->product_number;
        $consumption->cardholder_contact_number = $claim->getOnePhoneNumber();

        $consumption->claim_es_name = field_to_str($claim_type_visa->es_name, $fields_name);
        $consumption->claim_es_detail = field_to_str($claim_type_visa->es_detail, $fields_detail);
        $consumption->claim_es_detail_2 = field_to_str($claim_type_visa->es_detail_2, $fields_detail_2);

        $consumption->claim_en_name = field_to_str($claim_type_visa->en_name, $fields_name);
        $consumption->claim_en_detail = field_to_str($claim_type_visa->en_detail, $fields_detail);
        $consumption->claim_en_detail_2 = field_to_str($claim_type_visa->en_detail_2, $fields_detail_2);

        $consumption->response_date = $claim->response_date;

        $consumption->created_by = session()->get('user');
        $consumption->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $consumption->created_by_phone = session()->get('user_info')->getTelephoneNumber();

        $consumption->save();

        $transactions = collect();

        foreach ($request->transactions as $index) {
            $creditcard_statement = session()->get('tdc_transactions_claim')->get($index);

            $transaction = new Transaction;
            $transaction->id = uniqid(true);
            $transaction->form_id = $consumption->id;
            $transaction->form_type = 'CON';
            $transaction->transaction_date = $creditcard_statement->getFormatedDateTimeTransaction(true);
            $transaction->merchant_name = $creditcard_statement->getMerchantName();
            $transaction->country = $creditcard_statement->getCountry();
            $transaction->city = $creditcard_statement->getCity();
            $transaction->amount = $creditcard_statement->getAmount();

            $transactions->push($transaction);
        }

        $consumption->transactions()->saveMany($transactions->all());

        session()->forget('tdc_transactions_claim');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación de consumo ha sido creada correctamente.');
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
