<?php

namespace App\Http\Requests\SistemaMenu;

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
            'menu_id' => 'required|string|max:4|unique:SISTEMA_MENU,COD_MENU',
            'menu' => 'required|string|max:100|unique:SISTEMA_MENU,DES_MENU',
        ];
    }

    public function messages(){
        return [
            'menu_id.required'=>'El códgio del menú es obligatorio!',
            'menu_id.string'=>'El código del menú solo debe contener carácteres.',
            'menu_id.max'=>'El código del menú no debe ser mayor a 4 caracteres.',
            'menu_id.unique'=>'El código del menú ingresado ya existe, ingrese otro.',

            'menu.required'=>'El menú es obligatorio!',
            'menu.string'=>'El menú solo debe contener carácteres.',
            'menu.max'=>'El menú no debe ser mayor a 100 caracteres.',
            'menu.unique'=>'El menú ingresado ya existe, ingrese otro.',
        ];
    }
}
