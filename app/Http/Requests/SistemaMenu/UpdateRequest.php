<?php

namespace App\Http\Requests\SistemaMenu;

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
            'menu' => 'required|string|max:100|unique:SISTEMA_MENU,DES_MENU,'.$this->menu_id.',COD_MENU',
        ];
    }

    public function messages(){
        return [
            'menu.required'=>'El menu es obligatorio!',
            'menu.string'=>'El menu solo debe contener carácteres.',
            'menu.max'=>'El menu no debe ser mayo a 100 caracteres.',
            'menu.unique'=>'El menu ingresado ya existe, ingrese otro.',
        ];
    }
}
