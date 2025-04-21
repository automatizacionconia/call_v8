<?php

namespace App\Rules\Administrado;

use Illuminate\Contracts\Validation\Rule;

class LengthDocumento implements Rule
{
    public $length;
    public $tipoDocumento;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tipoDocumento)
    {        
        $this->tipoDocumento = $tipoDocumento;
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

        if($this->tipoDocumento=='02' || $this->tipoDocumento=='03'){ // '02' RUC '03' DNI

            $this->length = ($this->tipoDocumento=='02') ? 11 : 8;

            return trim(strlen($value)) == $this->length;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "El documento debe tener {$this->length} dígitos";
    }
}
