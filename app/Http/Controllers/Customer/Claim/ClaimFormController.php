<?php

namespace Bame\Http\Controllers\Customer\Claim;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Claim\Claim;
use Bame\Models\Customer\Claim\Param;
use Bame\Models\Customer\Product\CreditCardStatement;
use Bame\Models\Customer\Product\LoanMoneyMarket;
use Bame\Models\Customer\Product\CreditCard;
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

        if (in_array($form_type, ['CON', 'FRA'])) {
            if (!session()->has('tdc_transactions_claim')) {
                $creditcard_statements = CreditCardStatement::byCreditcard($claim->product_number)->get();
                session()->put('tdc_transactions_claim', $creditcard_statements);
            }
        }

        $view = view('customer.claim.form.create')
                ->with('form_type', $form_type)
                ->with('claim', $claim);

        if ($form_type == 'CON') {
            $claim_types_tdc = Param::activeOnly()->tdcOnly()->get();

            foreach ($claim_types_tdc as $claim_type_tdc) {

                $claim_type_tdc->es_name = str_to_field($claim_type_tdc->es_name, 'name_' . $claim_type_tdc->id);
                $claim_type_tdc->es_detail = str_to_field($claim_type_tdc->es_detail, 'detail_' . $claim_type_tdc->id);
                $claim_type_tdc->es_detail_2 = str_to_field($claim_type_tdc->es_detail_2, 'detail_2_' . $claim_type_tdc->id);

            }

            $view->with('claim_types_tdc', $claim_types_tdc);
        }

        if ($form_type == 'CAI') {
            if (in_array($claim->product_intranet, ['TARCRE', 'TARDEB'])) {
                $arrears_level = CreditCard::find($claim->product_number)
                                    ->balance($claim->currency == 'RD$' ? 214 : 840)
                                    ->first()->getPaymentsExpiredDays();
            } else if (in_array($claim->product_intranet, ['PRECOM', 'PRECON', 'PREHIP'])) {
                $loan_payments_plan = LoanMoneyMarket::find($claim->product_number)
                                    ->payments_plan()
                                    ->quotasExpired()->first();

                $arrears_level = $loan_payments_plan->daysExpired();
            }

            $view->with('arrears_level', $arrears_level);
        }

        return $view;
    }

    public function store(Request $request, $id, $form_type)
    {
        $messages = collect();

        $claim = Claim::find($id);

        if (!$claim) {
            return redirect(route('customer.claim.index'))->with('warning', 'Esta reclamación no existe!');
        }

        if ($claim->form) {
            return redirect(route('customer.claim.form', ['id' => $claim->form->id]));
        }

        $form = new Form;
        $form->id = uniqid(true);
        $form->claim_id = $claim->id;
        $form->form_type = $form_type;

        if ($form_type == 'CON') {

            if (!$request->claim_type_tdc) {
                return back()->with('warning', 'Debe seleccionar un tipo de reclamación de tarjeta.');
            }

            $claim_type_tdc = Param::tdcOnly()->find($request->claim_type_tdc);

            $fields_name = $request->input('fields_name_' . $request->claim_type_tdc);
            $fields_detail = $request->input('fields_detail_' . $request->claim_type_tdc);
            $fields_detail_2 = $request->input('fields_detail_2_' . $request->claim_type_tdc);

            $fields = array_merge($fields_name ?? [], $fields_detail ?? [], $fields_detail_2 ?? []);

            $messages = $this->validate_fields($claim_type_tdc, $fields, $request->transactions, $form_type);

            $form->claim_es_name = field_to_str($claim_type_tdc->es_name, $fields_name);
            $form->claim_es_detail = field_to_str($claim_type_tdc->es_detail, $fields_detail);
            $form->claim_es_detail_2 = field_to_str($claim_type_tdc->es_detail_2, $fields_detail_2);

            $form->claim_en_name = field_to_str($claim_type_tdc->en_name, $fields_name);
            $form->claim_en_detail = field_to_str($claim_type_tdc->en_detail, $fields_detail);
            $form->claim_en_detail_2 = field_to_str($claim_type_tdc->en_detail_2, $fields_detail_2);
        }

        if ($form_type == 'CAI') {

            $this->validate($request, [
                'capital' => 'numeric',
                'capital_discount_percent' => 'integer',
                'interest' => 'numeric',
                'interest_discount_percent' => 'integer',
                'arrears' => 'numeric',
                'arrears_discount_percent' => 'integer',
                'charges' => 'numeric',
                'charges_discount_percent' => 'integer',
                'others_charges' => 'numeric',
                'others_charges_discount_percent' => 'integer',
            ]);

            if (in_array($claim->product_intranet, ['TARCRE', 'TARDEB'])) {
                $arrears_level = CreditCard::find($claim->product_number)
                                    ->balance($claim->currency == 'RD$' ? 214 : 840)
                                    ->first()->getPaymentsExpiredDays();
            } else if (in_array($claim->product_intranet, ['PRECOM', 'PRECON', 'PREHIP'])) {
                $loan_payments_plan = LoanMoneyMarket::find($claim->product_number)
                                    ->payments_plan()
                                    ->quotasExpired()->first();

                $arrears_level = $loan_payments_plan->daysExpired();
            }

            $form->arrears_level = $arrears_level;

            $form->capital = floatval($request->capital);
            $form->capital_discount_percent = intval($request->capital_discount_percent);
            $form->capital_total = $form->capital - ($form->capital * ($form->capital_discount_percent / 100));

            $form->interest = floatval($request->interest);
            $form->interest_discount_percent = intval($request->interest_discount_percent);
            $form->interest_total = $form->interest - ($form->interest * ($form->interest_discount_percent / 100));

            $form->arrears = floatval($request->arrears);
            $form->arrears_discount_percent = intval($request->arrears_discount_percent);
            $form->arrears_total = $form->arrears - ($form->arrears * ($form->arrears_discount_percent / 100));

            $form->charges = floatval($request->charges);
            $form->charges_discount_percent = intval($request->charges_discount_percent);
            $form->charges_total = $form->charges - ($form->charges * ($form->charges_discount_percent / 100));

            $form->others_charges = floatval($request->others_charges);
            $form->others_charges_discount_percent = intval($request->others_charges_discount_percent);
            $form->others_charges_total = $form->others_charges - ($form->others_charges * ($form->others_charges_discount_percent / 100));

            $form->total_to_reverse = $form->capital_total + $form->interest_total + $form->arrears_total + $form->charges_total + $form->others_charges_total;

            $form->comments = $request->comments;

            if ($form->total_to_reverse <= 0) {
                $messages->push('Debe colocar al menos un cargo.');
            }
        }

        if ($messages->count()) {
            $request->session()->flash('messages_claim_form', $messages->values());
            return back();
        }

        $form->response_date = $claim->response_date;

        $form->created_by = session()->get('user');
        $form->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
        $form->created_by_phone = session()->get('user_info')->getTelephoneNumber();

        $form->save();

        do_log('Creó el Formulario Adicional a la Reclamación ( número:' . strip_tags($claim->claim_number) . ' )');

        if (in_array($form_type, ['CON', 'FRA'])) {

            if ($request->transactions){
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
            }

        }

        session()->forget('tdc_transactions_claim');

        return redirect(route('customer.claim.show', ['id' => $claim->id]))->with('success', 'La reclamación de ' . get_form_types($form_type) . ' ha sido creada correctamente.');
    }

    public function show($claim_id, $form_type, $id)
    {
        $form = Form::find($id);

        do_log('Consultó el Formulario Adicional de la Reclamación ( número:' . strip_tags($form->claim->claim_number) . ' )');

        return view('customer.claim.form.show')
                ->with('form', $form);
    }

    public function validate_fields($claim_type_tdc, $fields = [], $transactions = [], $form_type)
    {
        $messages = collect();

        // if (!count($transactions) || !$transactions){
        //     $messages->push('Debe seleccionar al menos una transacción.');
        // }

        if ($form_type == 'CON') {
            if ($claim_type_tdc) {
                $fields_count = substr_count($claim_type_tdc->es_name, '{field') +
                                    substr_count($claim_type_tdc->es_detail, '{field') +
                                    substr_count($claim_type_tdc->es_detail_2, '{field');

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
