<?php

namespace App\Events\Administrado;

use App\Http\Controllers\Api\Seguridad\Usuario\Models\Usuario;
use Illuminate\Queue\SerializesModels;

class NewRegisterOtroEvent
{
    use SerializesModels;

    public $administrado;
    public $tipo_documento_otro_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Usuario $administrado,$tipo_documento_otro_id)
    {
        $this->administrado = $administrado;
        $this->tipo_documento_otro_id = $tipo_documento_otro_id;
    }
}
