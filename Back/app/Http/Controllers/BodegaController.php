<?php

// app/Http/Controllers/BodegaController.php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Http\Requests\BodegaRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response; 
class BodegaController extends Controller
{
    public function store(BodegaRequest $request)
    {
        // Crear una nueva bodega
        $bodega = Bodega::create($request->validated());

        return response()->json($bodega, 201);
    }
    //funcion para mostrar todas las bodegas
    public function index()
    {
        // Obtener todos los artículos
        $bodegas = Bodega::all();

        return response()->json($bodegas);
    }
    //funcion para update de bodega
    public function update(Request $request, $id)
    {
        try {
            $bodega = Bodega::find($id);
            $bodega->nombreBodega = $request->nombreBodega;
            $bodega->save();

            return response()->json(["bodega" => $bodega], Response::HTTP_OK);
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
    //funcion para eliminar una bodega
    public function destroy($id)
    {
        try {
            $bodega = Bodega::find($id);
            $bodega->delete();

            return response()->json(["bodega" => $bodega], Response::HTTP_OK);
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
