<?php

namespace App\Http\Controllers\Api\Call\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CarteraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'cart_codigo' => $this->CART_CODIGO,
            'agen_codigo' => $this->AGEN_CODIGO,
            'agen_nombre' => $this->agente->AGEN_NOMBRE,
            'clie_codigo' => $this->CLIE_CODIGO,
            'clie_nombres' => $this->cliente->CLIE_NOMBRES,
            'clie_monto' => $this->cliente->CLIE_DEUDA,
            'clie_celular' => $this->cliente->CLIE_CELULAR,
            'cart_estado' => $this->CART_ESTADO,
            'cart_fecha_envio' => $this->CART_FECHENVIO ? Carbon::parse($this->CART_FECHENVIO)->format('Y-m-d H:i:s') : null,
            'grup_codigo' => optional($this->grupo)->GRUP_CODIGO ?? 0,
            'grup_nombre' => optional($this->grupo)->GRUP_NOMBRE ?? '[Sin grupo]',
            'esta_codigo' => $this->C_ESTA_CODIGO,
            'esta_nombre' => optional($this->estado)->C_ESTA_NOMBRE ?? '[Sin estado]',
        ];
    }
}
