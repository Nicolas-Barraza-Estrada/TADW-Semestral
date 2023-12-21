<?php

// app/Http/Controllers/ArticuloController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Articulo;
use App\Http\Requests\ArticuloRequest;
use App\Events\ArticuloCreado;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response; 
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


    //funcioin simple que modifica el nombre de un articulo recibiendo el id y el nuevo nombreArticulo, verifica que el nombre no exista en la tabla
    public function update(Request $request, $id)
    {
        try {
            $articulo = Articulo::find($id);
            $articulo->nombreArticulo = $request->nombreArticulo;
            $articulo->save();

            return response()->json(["articulo" => $articulo], Response::HTTP_OK);
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


    public function destroyByNombre(Request $request)
    {
        try {

            $articulo = Articulo::where('nombreArticulo', $request->nombreArticulo)->first();

            if (!$articulo) {
                throw ValidationException::withMessages([
                    'nombreArticulo' => ['No se encontró un artículo con ese nombre.'],
                ]);
            }

            $articulo->delete();

            return response()->json(["articulo" => $articulo], Response::HTTP_OK);
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
