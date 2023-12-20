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
            'nombreBodega' => 'required|string',
        ];
    }
}

