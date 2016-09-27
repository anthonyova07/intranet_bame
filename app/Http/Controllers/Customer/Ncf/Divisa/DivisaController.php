<?php

namespace Bame\Http\Controllers\Customer\Ncf\Divisa;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use DateTime;
use Bame\Models\Customer\Customer;
use Bame\Models\Customer\Ncf\Ncf;
use Bame\Models\Customer\Ncf\Detail;
use Bame\Models\CashTransaction\CashTransactionHistory;
use Bame\Models\CashTransaction\CashTransactionCurrent;

class DivisaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->customer_code) {
            $this->validate($request, [
                'day_from' => 'required|integer|between:1,31',
                'day_to' => 'required|integer|between:' . $request->day_from . ',31',
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
                'customer_code' => 'required|integer',
            ]);
        }

        $customer = Customer::find($request->customer_code);

        if (!$customer) {
            return view('customer.ncf.divisa.index');
        }

        $transactions_history = CashTransactionHistory::where('ticacd', '05')
            ->where('ticdch', '>', 0)
            ->where('ticocs', $customer->getCode());

        $transactions_current = CashTransactionCurrent::where('ticacd', '05')
            ->where('ticdch', '>', 0)
            ->where('ticocs', $customer->getCode());

        if ($request->day_from) {
            $transactions_history = $transactions_history->where('ticrdd', '>=', $request->day_from);
            $transactions_current = $transactions_current->where('ticrdd', '>=', $request->day_from);
        }

        if ($request->day_to) {
            $transactions_history = $transactions_history->where('ticrdd', '<=', $request->day_to);
            $transactions_current = $transactions_current->where('ticrdd', '<=', $request->day_to);
        }

        if ($request->month) {
            $transactions_history = $transactions_history->where('ticrdm', $request->month);
            $transactions_current = $transactions_current->where('ticrdm', $request->month);
        }

        if ($request->year) {
            $transactions_history = $transactions_history->where('ticrdy', $request->year);
            $transactions_current = $transactions_current->where('ticrdy', $request->year);
        }

        $transactions_history->union($transactions_current);

        $transactions = $transactions_history->get();

        if (!$transactions->count()) {
            session()->flash('warning', 'No se encontraron transacciones de divisas para el cliente ' . $customer->getName() . '.');
            return view('customer.ncf.divisa.index');
        }

        $customer->totalAmount = 0;
        $customer->month = $request->month;
        $customer->year = $request->year;

        $transactions->each(function ($transaction, $index) use ($customer) {
            $transaction->description = cap_str($transaction->getDescription());
            $customer->totalAmount += $transaction->getAmount();
        });

        session()->put('customer_divisa', $customer);
        session()->put('transactions_divisa', $transactions);

        return view('customer.ncf.divisa.index');
    }

    public function store(Request $request)
    {
        // try {
            $customer = session()->get('customer_divisa');

            if (!$customer) {
                return back()->with('warning', 'No existe cliente para guardar el ncf!');
            }

            $transactions = session()->get('transactions_divisa');

            if (!$transactions->count()) {
                return back()->with('warning', 'No existe transacciones para guardar el ncf!');
            }

            $datetime = new DateTime;

            $ncf = new Ncf;

            $ncf->encfact = Ncf::orderBy('encfact', 'desc')->first()->encfact + 1;
            $ncf->enccli = $customer->getCode();

            $ncf->encdiag = $datetime->format('d');
            $ncf->encmesg = $datetime->format('m');
            $ncf->encaniog = $datetime->format('Y');

            $ncf->encmesp = $customer->month;
            $ncf->encaniop = $customer->year;

            $ncf->encmonto = round($customer->totalAmount, 2);

            $ncf->encsts = 'A';
            $ncf->encreim = 0;
            $ncf->encsuc = 1;
            $ncf->encusr = session()->get('user');
            $ncf->enccta = 0;
            $ncf->encpub = 'S';
            $ncf->encccy = 'DOP';

            $ncf_sequence = DB::connection('ibs')->table('bacncf')->select('*')->where('ncfsuc', 1)->first();

            if (!$ncf_sequence) {
                return back()->with('warning', 'No existen ncf disponibles!');
            }

            $ncf_next_sequence = $ncf_sequence->ncfdes + 1;

            $ncf->encncf = $ncf_sequence->ncfcod . str_pad($ncf_next_sequence, 8, '0', STR_PAD_LEFT);

            $ncf->save();

            DB::connection('ibs')->table('bacncf')->where('ncfsuc', 1)->update([
                'ncfdes' => $ncf_next_sequence
            ]);

            $transactions->each(function ($transaction, $index) use ($ncf) {
                $detail = new Detail;

                $detail->detcant = 1;
                $detail->detfac = $ncf->encfact;
                $detail->detcta = 0;
                $detail->detsec = $index + 1;
                $detail->detdesc = $transaction->description;
                $detail->detccy = 'DOP';
                $detail->dettas = 0;
                $detail->detmto = round($transaction->getAmount(), 2);
                $detail->detdia = $transaction->getDay();
                $detail->detmes = $transaction->getMonth();
                $detail->detanio = $transaction->getYear();
                $detail->deasts = 'A';
                $detail->detitb = $transaction->tax_amount;

                $detail->save();
            });

            do_log('Generó un NCF (Divisa) ( ncf:' . $ncf->encncf . ' factura:' . $ncf->encfact . ' )');

            session()->forget('customer_divisa');
            session()->forget('transactions_divisa');

            return back()
                ->with('success', 'El ncf ' . $ncf->encncf . ' a sido creado satisfactoria mente. El # de factura es: ' . $ncf->encfact . ' ')
                ->with('link', route('customer.ncf.show', ['id' => $ncf->encfact]));

        // } catch (\Exception $e) {
        //     return back()->with('error', 'El Ncf no pudo ser generado: ' . $e->getMessage());
        // }
    }

    public function destroy($id)
    {
        session()->forget('customer_divisa');
        session()->forget('transactions_divisa');

        return redirect(route('customer.ncf.divisa.new.index'))
            ->with('success', 'El Ncf Divisa ha sido cancelado con exito.');
    }
}
