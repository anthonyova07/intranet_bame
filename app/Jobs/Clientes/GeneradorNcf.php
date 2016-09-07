<?php

namespace Bame\Jobs\Clientes;

use Bame\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Bame\Models\Clientes\Ncf;
use Bame\Models\Clientes\NcfDetalle;

class GeneradorNcf extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $factura;
    protected $usuario;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($factura, $usuario)
    {
        $this->factura = $factura;
        $this->usuario = $usuario;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ncf = Ncf::get($this->factura);

        if (!$ncf) {
            $noti = new Notificacion($this->usuario);
            $noti->create('Clientes NCF', 'La factura ' . $this->factura . ' no existe!');
            $noti->save();
            return false;
        }

        $detalles = NcfDetalle::all($ncf->FACTURA, true);

        if (!$detalles) {
            $noti = new Notificacion($this->usuario);
            $noti->create('Clientes NCF', 'La factura ' . $this->factura . ' no tiene un detalle!');
            $noti->save();
            return false;
        }

        $detalles = NcfDetalle::formatAll($detalles);

        $fecha_hora = (new \Datetime)->format('Y_m_d_H_i_s');

        $html = view('pdfs.ncf_detalle', ['ncf' => $ncf, 'detalles' => $detalles])->render();

        $archivo = env('NCF_CARPETA_PDF') . $fecha_hora . '_' . $ncf->FACTURA . '_' . str_replace('.', '_', $this->usuario) . '_ncfs.pdf';

        NcfDetalle::generatePdf($html, $archivo);
    }
}
