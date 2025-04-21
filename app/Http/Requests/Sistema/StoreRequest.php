<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required|string|max:100|unique:SISTEMA,COD_SISTEMA',
        ];
    }

    public function messages(){
        return [
            'descripcion.required'=>'El campo descripción es obligatorio!',
            'descripcion.string'=>'El descripción solo debe contener carácteres.',
            'descripcion.max'=>'El descripción no debe ser mayor a 100 caracteres.',
            'descripcion.unique'=>'La descripción del cargo ingresado ya existe, ingrese otro.',
        ];
    }
}
