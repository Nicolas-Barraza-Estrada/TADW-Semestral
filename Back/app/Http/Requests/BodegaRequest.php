<?php

// app/Http/Requests/BodegaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BodegaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombreBodega' => 'required|string|max:255|unique:bodegas',
        ];
    }

    public function messages()
    {
        return [
            'nombreBodega.required' => 'El nombre de la bodega es requerido',
            'nombreBodega.string' => 'El nombre de la bodega debe ser un string',
            'nombreBodega.max' => 'El nombre de la bodega debe tener máximo 255 caracteres',
            'nombreBodega.unique' => 'El nombre de la bodega ya existe',
        ];
    }
}

