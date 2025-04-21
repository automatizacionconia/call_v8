<?php

namespace App\Http\Requests\Usuario;

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
            'id' => 'required|string|max:30|unique:USUARIO,COD_USUARIO',
            'usuario' => 'required|string|max:100|unique:USUARIO,NOM_USUARIO',
        ];
    }

    public function messages(){
        return [
            'id.required'=>'El código de usuario es obligatorio!',
            'id.string'=>'El código de usuario solo debe contener carácteres.',
            'id.max'=>'El código de usuario no debe ser mayor a 30 caracteres.',
            'id.unique'=>'El código de usuario del cargo ingresado ya existe, ingrese otro.',

            'usuario.required'=>'El nombre de usuario es obligatorio!',
            'usuario.string'=>'El nombre de usuario solo debe contener carácteres.',
            'usuario.max'=>'El nombre de usuario no debe ser mayor a 100 caracteres.',
            'usuario.unique'=>'El nombre de usuario ingresado ya existe, ingrese otro.',
        ];
    }
}
