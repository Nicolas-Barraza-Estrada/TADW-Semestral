<?php

// app/Http/Controllers/ArticuloController.php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Http\Requests\ArticuloRequest;
use App\Events\ArticuloCreado;
use Illuminate\Support\Facades\Event;

class ArticuloController extends Controller
{
    public function index()
    {
        // Obtener todos los artículos
        $articulos = Articulo::all();

        return response()->json($articulos);
    }

    public function store(ArticuloRequest $request)
    {
        $articulo = Articulo::create($request->validated());

        // Disparar evento para crear ArticuloEnBodega
        event(new ArticuloCreado($articulo));

        return response()->json($articulo, 201);
    }

    public function show(Articulo $articulo)
    {
        // Mostrar un artículo específico
        return response()->json($articulo);
    }

    public function update(ArticuloRequest $request, Articulo $articulo)
    {
        // Actualizar un artículo existente
        $articulo->update($request->validated());

        return response()->json($articulo);
    }

    public function destroy(Articulo $articulo)
    {
        // Eliminar un artículo
        $articulo->delete();

        return response()->json(null, 204);
    }
}
