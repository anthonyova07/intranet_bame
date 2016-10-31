<?php

namespace Bame\Http\Controllers\Customer\Ncf\NoIbs;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DB;
use DateTime;
use Bame\Models\Customer\Ncf\Ncf;
use Bame\Models\Customer\Ncf\Detail;

class NoIbsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->to_name) {
            $this->validate($request, [
                'to_name' => 'required|max:45',
                'identification_type' => 'required|in:' . get_identification_types()->keys()->implode(','),
                'identification' => 'required|alpha_num|max:15',
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
            ]);

            $cliente = new \stdClass;

            $cliente->to_name = cap_str($request->to_name);
            $cliente->identification_type = $request->identification_type;
            $cliente->identification = strtoupper($request->identification);
            $cliente->month = $request->month;
            $cliente->year = $request->year;

            session()->put('customer_no_ibs', $cliente);
            session()->put('transactions_no_ibs', collect());
        }

        return view('customer.ncf.no_ibs.index');
    }

    public function store(Request $request)
    {
        try {
            $customer = session()->get('customer_no_ibs');

            if (!$customer) {
                return back()->with('warning', 'No existe cliente para guardar el ncf!');
            }

            $transactions = session()->get('transactions_no_ibs');

            if (!$transactions->count()) {
                return back()->with('warning', 'No existe transacciones para guardar el ncf!');
            }

            $datetime = new DateTime;

            $ncf = new Ncf;

            $ncf->encfact = Ncf::orderBy('encfact', 'desc')->first()->encfact + 1;
            $ncf->enccli = 0;

            $ncf->encdiag = $datetime->format('d');
            $ncf->encmesg = $datetime->format('m');
            $ncf->encaniog = $datetime->format('Y');

            $ncf->encmesp = $customer->month;
            $ncf->encaniop = $customer->year;

            $ncf->encmonto = round($transactions->sum('amount') + $transactions->sum('tax_amount'), 2);

            $ncf->encsts = 'A';
            $ncf->encreim = 0;
            $ncf->encsuc = 1;
            $ncf->encusr = session()->get('user');
            $ncf->enccta = 0;
            $ncf->enctid = $customer->identification_type;
            $ncf->encidn = $customer->identification;
            $ncf->encnom = $customer->to_name;
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
                $detail->dettas = 1;
                $detail->detmto = round($transaction->amount, 2);
                $detail->detdia = $transaction->day;
                $detail->detmes = $transaction->month;
                $detail->detanio = $transaction->year;
                $detail->deasts = 'A';
                $detail->detitb = round($transaction->tax_amount, 2);

                $detail->save();
            });

            do_log('Generó un NCF (NoIBS) ( ncf:' . $ncf->encncf . ' factura:' . $ncf->encfact . ' )');

            session()->forget('customer_no_ibs');
            session()->forget('transactions_no_ibs');

            return back()
                ->with('success', 'El ncf ' . $ncf->encncf . ' a sido creado satisfactoria mente. El # de factura es: ' . $ncf->encfact . ' ')
                ->with('link', route('customer.ncf.show', ['id' => $ncf->encfact]));

        } catch (\Exception $e) {
            return back()->with('error', 'El Ncf no pudo ser generado: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        session()->forget('customer_no_ibs');
        session()->forget('transactions_no_ibs');

        return redirect(route('customer.ncf.no_ibs.new.index'))->with('success', 'El Ncf NoIbs ha sido cancelado con exito.');
    }
}
