<?php

// app/Http/Controllers/ArticuloEnBodegaController.php

namespace App\Http\Controllers;

use App\Models\ArticuloEnBodega;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response; // Agrega esta línea

class ArticuloEnBodegaController extends Controller
{
    public function update(Request $request)
{
    //valida que llegen los datos articulo_id , bodega_id , cantidadArticulo
    $request->validate([
        'articulo_id' => 'required|integer',
        'bodega_id' => 'required|integer',
        'cantidadArticulo' => 'required|integer',
    ]);
}
//funcion index para mostrar todos los articulos en bodegas 
public function index()
{
    // Obtener todos los articulos en bodegas
    $articulosEnBodega = ArticuloEnBodega::all();

    return response()->json($articulosEnBodega);
}

//funcion index para mostrar los articulos en bodegas por bodega_id
public function show($bodega_id)
{
    // Obtener todos los articulos en bodegas
    $articulosEnBodega = ArticuloEnBodega::where('bodega_id', $bodega_id)->get();

    return response()->json($articulosEnBodega);
}

//funcion para añadir 100 a todas las cantidadArticulo (de todas las bodega_id y articulo_id) 
public function add10()
{
    try {
        $articulosEnBodega = ArticuloEnBodega::all();
        foreach ($articulosEnBodega as $articuloEnBodega) {
            $articuloEnBodega->cantidadArticulo += 10;
            $articuloEnBodega->save();
        }

        return response()->json(["articulosEnBodega" => $articulosEnBodega], Response::HTTP_OK);
    } catch (\Exception $e) {
        Log::info([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ]);

        return response()->json([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ], Response::HTTP_BAD_REQUEST);
    }
}

//funcion que recibe un articulo_id y bodega_id y retorna la cantidadArticulo
public function getCantidadArticulo(Request $request)
{
    try {
        $articuloEnBodega = ArticuloEnBodega::where('bodega_id', $request->bodega_id)
            ->where('articulo_id', $request->articulo_id)
            ->firstOrFail();

        return response()->json(["articuloEnBodega" => $articuloEnBodega], Response::HTTP_OK);
    } catch (\Exception $e) {
        Log::info([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ]);

        return response()->json([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ], Response::HTTP_BAD_REQUEST);
    }
}
    //funcion para descontar la cantidad de un articulo en una bodega rcibiendo el bodega_id y articulo_id 
    //(comprueba que la cantidad a descontar sea menor a la cantidad actual)
    public function descontarCantidadArticulo(Request $request)
    {
        try {
            $articuloEnBodega = ArticuloEnBodega::where('bodega_id', $request->bodega_id)
                ->where('articulo_id', $request->articulo_id)
                ->firstOrFail();
            if ($articuloEnBodega->cantidadArticulo < $request->cantidadArticulo) {
                throw ValidationException::withMessages([
                    'cantidadArticulo' => ['No se puede descontar una cantidad mayor a la existente.'],
                ]);
            }
            $articuloEnBodega->cantidadArticulo -= $request->cantidadArticulo;
            $articuloEnBodega->save();

            return response()->json(["articuloEnBodega" => $articuloEnBodega], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info([
                "error" => $e->getMessage(),
                "linea" => $e->getLine(),
                "file" => $e->getFile(),
                "metodo" => __METHOD__
            ]);

            return response()->json([
                "error" => $e->getMessage(),
                "linea" => $e->getLine(),
                "file" => $e->getFile(),
                "metodo" => __METHOD__
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    //funcion simple para eliminar por articulo_id para todas las bodegas
    public function destroyByArticuloId($articulo_id)
    {
        try {
            $articuloEnBodega = ArticuloEnBodega::where('articulo_id', $articulo_id)->delete();

            return response()->json(["articuloEnBodega" => $articuloEnBodega], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info([
                "error" => $e->getMessage(),
                "linea" => $e->getLine(),
                "file" => $e->getFile(),
                "metodo" => __METHOD__
            ]);

            return response()->json([
                "error" => $e->getMessage(),
                "linea" => $e->getLine(),
                "file" => $e->getFile(),
                "metodo" => __METHOD__
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
//funcion para el traspaso de cantidadArticulo entre bodegas
public function traspaso(Request $request)
{   
    Log::info('Bodega ID Emisora: ' . $request->bodega_idOrigen);
    Log::info('Articulo ID: ' . $request->articulo_id);
    Log::info('Bodega ID Receptora: ' . $request->bodega_idDestino);
    Log::info('Cantidad a descontar: ' . $request->cantidadArticulo);
    try {
        $articuloEnBodegaEmisora = ArticuloEnBodega::where('bodega_id', $request->bodega_idOrigen)
            ->where('articulo_id', $request->articulo_id)
            ->firstOrFail();
        if ($articuloEnBodegaEmisora->cantidadArticulo < $request->cantidadArticulo) {
            throw ValidationException::withMessages([
                'cantidadArticulo' => ['No se puede descontar una cantidad mayor a la existente.'],
            ]);
        }
        $articuloEnBodegaEmisora->cantidadArticulo -= $request->cantidadArticulo;
        $articuloEnBodegaEmisora->save();

        $articuloEnBodegaReceptora = ArticuloEnBodega::where('bodega_id', $request->bodega_idDestino)
            ->where('articulo_id', $request->articulo_id)
            ->firstOrFail();
        $articuloEnBodegaReceptora->cantidadArticulo += $request->cantidadArticulo;
        $articuloEnBodegaReceptora->save();

        return response()->json([
            "articuloEnBodegaEmisora" => $articuloEnBodegaEmisora,
            "articuloEnBodegaReceptora" => $articuloEnBodegaReceptora
        ], Response::HTTP_OK);
    } catch (\Exception $e) {
        Log::info([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ]);

        return response()->json([
            "error" => $e->getMessage(),
            "linea" => $e->getLine(),
            "file" => $e->getFile(),
            "metodo" => __METHOD__
        ], Response::HTTP_BAD_REQUEST);
    }
}


}