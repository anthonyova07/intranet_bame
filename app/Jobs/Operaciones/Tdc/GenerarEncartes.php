<?php

namespace Bame\Jobs\Operaciones\Tdc;

use Bame\Jobs\Job;
use Bame\Models\Operaciones\Tdc\Encarte;
use Bame\Models\Notificaciones\Notificacion;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerarEncartes extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $filtros;

    protected $usuario;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filtros, $usuario)
    {
        $this->filtros = $filtros;
        $this->usuario = $usuario;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->filtros->has('identificacion')) {
            Encarte::addIdentificationFilter($this->filtros->get('identificacion'));
        }

        if ($this->filtros->has('tarjeta')) {
            Encarte::addCreditCardFilter($this->filtros->get('tarjeta'));
        }

        if ($this->filtros->has('fecha')) {
            Encarte::addFechaFilter($this->filtros->get('fecha'));
        }

        if ($this->filtros->get('todos_pendientes')) {
            Encarte::allPending();
        }

        Encarte::orderByCreditCard();

        $tarjetas = Encarte::all();

        if (!$tarjetas) {
            return false;
        }

        $tarjetas_procesadas = Encarte::getCreditCardNumbers($tarjetas);

        $tarjetas = Encarte::formatAll($tarjetas);

        $archivo = env('ENCARTES_CARPETA_PDF') . (new \DateTime)->format('Y_m_d_H_i_s') . '_';

        $trozos = $tarjetas->chunk(env('ENCARTE_CANTIDAD_POR_ARCHIVO'));

        $trozos->each(function ($tarjetas, $index) use ($archivo) {
            $html = view('pdfs.encartes', ['tarjetas' => $tarjetas])->render();

            $archivo .= $index . '_encartes.pdf';

            Encarte::generatePdf($html, $archivo);
        });

        Encarte::markCreditCards($tarjetas_procesadas);

        $noti = new Notificacion($this->usuario);
        $noti->create('Encartes', 'La generación de los encartes ha finalizado con éxito!');
        $noti->save();
    }
}
