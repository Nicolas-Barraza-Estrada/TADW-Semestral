<?php

// app/Http/Controllers/BodegaController.php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Http\Requests\BodegaRequest;

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
}
