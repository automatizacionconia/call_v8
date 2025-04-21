<?php

namespace App\Rules\Remito;

use Illuminate\Contracts\Validation\Rule;

class MaxLenghtNameFile implements Rule
{

    public $file;

    public $caracteres = 191;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $file = $file;
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
        return strlen($value->getClientOriginalName()) <= $this->caracteres ? true : false; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "El nombre del documento adjunto no debe tener mas de {$this->caracteres}";
    }
}
