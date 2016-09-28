<?php

namespace Bame\Http\Controllers\Customer\Ncf;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Customer\Ncf\Ncf;
use Bame\Models\Customer\Ncf\Detail;
use Bame\Http\Requests\Customer\Ncf\Divisa\Detail\EditRequest;

class DetailController extends Controller
{
    public function index($invoice)
    {
        $ncf = Ncf::where('encfact', $invoice)->first();

        if (!$ncf) {
            return back()->with('warning', 'Este factura no existe!');
        }

        $details = Detail::where('detfac', $ncf->getInvoice())
            ->get();

        do_log('Consultó el detalle NCF de ( factura:' . $ncf->getInvoice() . ' )');

        return view('customer.ncf.detail.index')
            ->with('ncf', $ncf)
            ->with('details', $details);
    }

    public function edit($invoice, $id)
    {
        $detail = Detail::where('detfac', $invoice)->find($id);

        if (!$detail) {
            return back()->with('warning', 'Esta detalle no existe!');
        }

        return view('customer.ncf.detail.edit')
        ->with('detail', $detail);
    }

    public function update(EditRequest $request, $invoice, $id)
    {
        $detail = Detail::where('detfac', $invoice)->find($id);

        if (!$detail) {
            return back()->with('warning', 'Esta detalle no existe!');
        }

        $detail->detdesc = cap_str($request->description);

        Detail::where('detfac', $invoice)
            ->where('detsec', $id)
            ->update([
                'detdesc' => cap_str($request->description)
            ]);

        return redirect(route('customer.ncf.{invoice}.detail.index', [
            'invoice' => $invoice
        ]))->with('success', 'El detalle ha sido editado con exito.');
    }

    public function destroy($invoice, $id)
    {
        $detail = Detail::where('detfac', $invoice)->find($id);

        if (!$detail) {
            return back()->with('warning', 'Este detalle no existe!');
        }

        $ncf = Ncf::find($invoice);

        if ($detail->getStatus() == 'R') {
            Detail::where('detfac', $invoice)
                ->where('detsec', $id)
                ->update([
                    'deasts' => 'A'
                ]);

            $ncf->setAmount($ncf->getAmount(false) + ($detail->getAmount(false) + $detail->getTaxAmount(false)));

            $ncf->save();

            do_log('Activo un detalle NCF ( factura:' . $ncf->getInvoice() . ' secuencia:' . $detail->getSequence() . ' )');

            return back()->with('success', 'El detalle fue activado correctamente.');
        }

        Detail::where('detfac', $invoice)
            ->where('detsec', $id)
            ->update([
                'deasts' => 'R'
            ]);

        $ncf->setAmount($ncf->getAmount(false) - ($detail->getAmount(false) + $detail->getTaxAmount(false)));

        $ncf->save();

        do_log('Anuló un detalle NCF ( factura:' . $ncf->getInvoice() . ' secuencia:' . $detail->getSequence() . ' )');

        return back()->with('success', 'El detalle fue anulado correctamente.');
    }
}
