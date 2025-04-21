<?php

namespace App\Http\Requests\Usuario;

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
            'usuario' => 'required|string|max:100|unique:USUARIO,NOM_USUARIO,'.$this->id.',COD_USUARIO',
        ];
    }

    public function messages(){
        return [
            'usuario.required'=>'El nombre de usuario es obligatorio!',
            'usuario.string'=>'El nombre de usuario solo debe contener carácteres.',
            'usuario.max'=>'El nombre de usuario no debe ser mayor a 100 caracteres.',
            'usuario.unique'=>'El nombre de usuario ingresado ya existe, ingrese otro.',
        ];
    }
}
