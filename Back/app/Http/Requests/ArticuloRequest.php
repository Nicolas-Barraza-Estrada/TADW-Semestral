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
            'nombreArticulo' => 'required|string',
            'presentacionArticulo' => 'required|string',
        ];
    }
}
