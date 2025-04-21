<?php

namespace App\Http\Requests\Documento;

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
            'descripcion' => 'required|string|max:100|unique:DOCUMENTO,DES_DOC,'.$this->id.',COD_DOC',
            'abreviado' => 'required|string|max:10',
        ];
    }

    public function messages(){
        return [
            'descripcion.required'=>'El campo descripcion es obligatorio!',
            'descripcion.string'=>'La descripcion solo debe contener carácteres.',
            'descripcion.max'=>'La descripcion no debe ser mayo a 100 caracteres.',
            'descripcion.unique'=>'La descripcion ingresada ya existe, ingrese otro.',

            'abreviado.required'=>'El campo abreviado es obligatorio!',
            'abreviado.string'=>'El abreviado solo debe contener carácteres.',
            'abreviado.max'=>'El abreviado no debe ser mayor a 10 caracteres.',
        ];
    }
}
