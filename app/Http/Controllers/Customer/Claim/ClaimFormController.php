<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Claim;
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
            $creditcard_statements = CreditCardStatement::where('numta_dect', $claim->product_number)->get();
            session()->put('tdc_transactions_claim', $creditcard_statements);
        }

        return view('customer.claim.form.consumption.index')
                ->with('id', $id)
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

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->consumption) {
            return redirect(route('customer.claim.consumption', ['id' => $claim->consumption->id]));
        }

        $fields = $request->input('fields' . $request->claim_type);

        $messages = $this->validate_fields($request->claim_type, $fields, $request->transactions);

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

        $claim_type = get_claim_types_visa($request->claim_type, $fields);

        $consumption->claim_es_name = $claim_type->es_name;
        $consumption->claim_es_detail = $claim_type->es_detail;
        $consumption->claim_es_detail_2 = $claim_type->es_detail_2;

        $consumption->claim_en_name = $claim_type->en_name;
        $consumption->claim_en_detail = $claim_type->en_detail;
        $consumption->claim_en_detail_2 = $claim_type->en_detail_2;

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
            $transaction->transaction_date = $creditcard_statement->getFormatedDateTransaction(true);
            $transaction->merchant_name = $creditcard_statement->getConcept();
            $transaction->amount = $creditcard_statement->getAmount();

            $transactions->push($transaction);
        }

        $consumption->transactions()->saveMany($transactions->all());

        session()->forget('tdc_transactions_claim');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación de consumo ha sido creada correctamente.');
    }

    public function validate_fields($claim, $fields = [], $transactions = [])
    {
        $messages = collect();

        if (!count($transactions) || !$transactions){
            $messages->push('Debe seleccionar al menos una transacción.');
        }

        if ($claim) {
            $claim = get_claim_types_visa($claim);

            if ($claim->required_fields) {
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

        return $messages;
    }
}
