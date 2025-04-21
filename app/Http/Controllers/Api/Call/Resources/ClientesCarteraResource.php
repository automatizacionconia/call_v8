<?php

namespace App\Http\Controllers\Api\Call\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientesCarteraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'clie_codigo' => $this->CLIE_CODIGO,
            'clie_nombres' => $this->CLIE_NOMBRES,
            'clie_suscriptor' => $this->CLIE_SUSCRIPTOR,
            'clie_cedula' => $this->CLIE_CEDULA,
            'clie_cuenta' => $this->CLIE_CUENTA,
            'clie_deuda' => $this->CLIE_DEUDA,
            'clie_celular' => $this->CLIE_CELULAR,
        ];
    }
}
