<?php

namespace App\Http\Controllers\Api\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'empr_codigo' => $this->EMPR_CODIGO,
            'empr_nombre' => $this->EMPR_NOMBRE,
            'empr_abrev' => $this->EMPR_ABREV,
            'empr_direccion' => $this->EMPR_DIRECCION,
            'empr_ruc' => $this->EMPR_RUC,
            'empr_estado' => $this->EMPR_ESTADO,
        ];
    }

}
