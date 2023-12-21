<?php

// app/Http/Requests/ArticuloEnBodegaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloEnBodegaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cantidadArticulo' => 'required|integer',
        ];
    }
}
