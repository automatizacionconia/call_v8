<?php

namespace App\Http\Requests\SedeOrganizacional;

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
            'descripcion' => 'required|string|max:80|unique:SEDE_ORGANIZACIONAL,DES_SEDE,'.$this->id.',COD_SEDE',
            'abreviado' => 'required|string|max:80',
        ];
    }

    public function messages(){
        return [
            'descripcion.required'=>'La sede es obligatoria!',
            'descripcion.string'=>'La sede solo debe contener carácteres.',
            'descripcion.max'=>'La sede no debe ser mayo a 80 caracteres.',
            'descripcion.unique'=>'La sede ingresada ya existe, ingrese otro.',

            'abreviado.required'=>'El nombre abreviado es obligatorio!',
            'abreviado.string'=>'El nombre abreviado solo debe contener carácteres.',
            'abreviado.max'=>'El nombre abreviado no debe ser mayor a 80 caracteres.',
        ];
    }
}
