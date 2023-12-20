<?php

namespace App\Listeners;

use App\Events\ArticuloCreado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Bodega;
use App\Models\ArticuloEnBodega;

class CrearArticuloEnBodegas
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ArticuloCreado  $event
     * @return void
     */
    public function handle(ArticuloCreado $event)
    {
        $bodegas = Bodega::all();

        foreach ($bodegas as $bodega) {
            ArticuloEnBodega::create([
                'articulo_id' => $event->articulo->id,
                'bodega_id' => $bodega->id,
                'cantidadArticulo' => 0,
            ]);
        }
    }
}
