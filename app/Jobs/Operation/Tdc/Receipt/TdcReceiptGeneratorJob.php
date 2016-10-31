<?php

namespace Bame\Jobs\Operation\Tdc\Receipt;

use DB;
use Bame\Jobs\Job;
use Bame\Models\Operation\Tdc\Receipt\TdcReceipt;
use Bame\Models\Notification\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TdcReceiptGeneratorJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $filters;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filters, $user)
    {
        $this->filters = $filters;
        $this->user = $user;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $receipts = TdcReceipt::orderBy('numta_entr');

        if ($this->filters->has('identification')) {
            $receipts = $receipts->where('ident_entr', $this->filters->get('identification'));
        }

        if ($this->filters->has('credit_card')) {
            $receipts = $receipts->where('numta_entr', $this->filters->get('credit_card'));
        }

        if ($this->filters->has('date')) {
            $receipts = $receipts->where('fecen_entr', $this->filters->get('date'));
        }

        if ($this->filters->get('all_pending')) {
            $receipts = $receipts->where('stsen_entr', '');
        }

        $credit_cards = $receipts->get();

        if (!$credit_cards->count()) {
            $noti = new Notification($this->user);
            $noti->create('Encartes', 'No se encontraron encartes de acuerdo a los parametros suministrados!');
            $noti->save();
            return false;
        }

        $credit_cards_processed = $credit_cards->pluck('numta_entr')->toArray();

        $wrapped_dates = $credit_cards->pluck('fecen_entr');

        $request_types = DB::connection('itc')
            ->table('satdesc00')
            ->select('trim(prefi_desc) prefi_desc, integer(trim(codig_desc)) codig_desc, trim(nombr_desc) nombr_desc')
            ->where('prefi_desc', 'SAT_TSOL')
            ->get();
        $request_types = collect($request_types);

        $descriptions_tdc_bin = DB::connection('itc')
            ->table('envia.encartbin')
            ->get();
        $descriptions_tdc_bin = collect($descriptions_tdc_bin);

        $current_time = (new \Datetime)->format('H:i:s');

        $wrapped_dates->unique()->each(function ($wrapped_date, $index) use ($credit_cards, $current_time, $request_types, $descriptions_tdc_bin) {
            $chunks = $credit_cards->where('fecen_entr', $wrapped_date)->chunk(env('ENCARTE_CANTIDAD_POR_ARCHIVO'));

            $chunks->each(function ($credit_cards, $index) use ($wrapped_date, $current_time, $request_types, $descriptions_tdc_bin) {
                $html = view('pdfs.tdc_receipt')
                    ->with('credit_cards', $credit_cards)
                    ->with('request_types', $request_types)
                    ->with('descriptions_tdc_bin', $descriptions_tdc_bin)
                    ->render();

                $archivo = env('ENCARTES_CARPETA_PDF') . format_datetime_to_file($wrapped_date, $current_time) . '_' . $index . '_encartes.pdf';

                TdcReceipt::generatePdf($html, $archivo);
            });
        });

        TdcReceipt::whereIn('numta_entr', $credit_cards_processed)
            ->update([
                'stsen_entr' => 'P'
            ]);

        $noti = new Notification($this->user);
        $noti->create('Encartes', 'La generacion de los encartes ha finalizado con exito!');
        $noti->save();
    }
}
