<?php

// app/Http/Requests/ArticuloRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombreArticulo' => 'required|string|unique:articulos,nombreArticulo',
            'presentacionArticulo' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'nombreArticulo.required' => 'El nombre del artículo es requerido',
            'nombreArticulo.string' => 'El nombre del artículo debe ser una cadena de caracteres',
            'nombreArticulo.unique' => 'El nombre del artículo ya existe',
            'presentacionArticulo.required' => 'La presentación del artículo es requerida',
            'presentacionArticulo.string' => 'La presentación del artículo debe ser una cadena de caracteres',
        ];
    }
}
