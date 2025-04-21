<?php

namespace App\Http\Requests\Sistema;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required|string|max:100|unique:SISTEMA,DES_SISTEMA,'.$this->id.',COD_SISTEMA',
        ];
    }

    public function messages(){
        return [
            'descripcion.required'=>'El campo descripcion es obligatorio!',
            'descripcion.string'=>'La descripcion solo debe contener carácteres.',
            'descripcion.max'=>'La descripcion no debe ser mayo a 100 caracteres.',
            'descripcion.unique'=>'El nombre del sistema ingresado ya existe, ingrese otro.',
        ];
    }
}
