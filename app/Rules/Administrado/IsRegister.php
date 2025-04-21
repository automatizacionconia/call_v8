<?php

namespace App\Rules\Administrado;

use App\Http\Controllers\Api\Seguridad\Usuario\Models\Usuario;
use Illuminate\Contracts\Validation\Rule;

class IsRegister implements Rule
{
    public $user;    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {                
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->user = Usuario::where('COD_USUARIO',$value)->first();

        return !$this->user;        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "La cuenta esta asociada al correo electrónico {$this->user->TXTEMAIL}";
    }
}
