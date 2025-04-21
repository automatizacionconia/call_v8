<?php

namespace App\Http\Requests\SedeOrganizacional;

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
            'descripcion' => 'required|string|max:80|unique:SEDE_ORGANIZACIONAL,DES_SEDE',
            'abreviado' => 'required|string|max:80',
        ];
    }

    public function messages(){
        return [
            'descripcion.required'=>'El campo descripción es obligatorio!',
            'descripcion.string'=>'El descripción solo debe contener carácteres.',
            'descripcion.max'=>'El descripción no debe ser mayor a 80 caracteres.',
            'descripcion.unique'=>'La sede ingresada ya existe, ingrese otro.',

            'abreviado.required'=>'El campo abreviado es obligatorio!',
            'abreviado.string'=>'El campo abreviado solo debe contener carácteres.',
            'abreviado.max'=>'El campo abreviado no debe ser mayor a 80 caracteres.',
        ];
    }
}
