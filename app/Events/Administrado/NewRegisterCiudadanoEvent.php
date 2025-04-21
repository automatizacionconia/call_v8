<?php

namespace App\Events\Administrado;

use App\Http\Controllers\Api\Seguridad\Usuario\Models\Usuario;
use Illuminate\Queue\SerializesModels;

class NewRegisterCiudadanoEvent
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
        //dd($administrado);
        $this->administrado = $administrado;
    }
}
