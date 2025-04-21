<?php

namespace App\Events\Administrado;

use App\Http\Controllers\Api\Seguridad\Usuario\Models\Usuario;
use Illuminate\Queue\SerializesModels;

class NewRegisterJuridicaEvent
{
    use SerializesModels;

    public $administrado;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Usuario $administrado)
    {        
        $this->administrado = $administrado;
    }
}
