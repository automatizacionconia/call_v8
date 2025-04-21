<?php

namespace App\Http\Controllers\Api\Call\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Api\Call\Resources\CarteraResource;
class AgentesCarteraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'agen_codigo' => $this->AGEN_CODIGO,
            'agen_nombre' => $this->AGEN_NOMBRE,
            'plat_codigo' => $this->plataforma->PLAT_CODIGO,
            'plat_nombre' => $this->plataforma->PLAT_NOMBRE,
            'agen_api' => $this->AGEN_API,
            'agen_key' => $this->AGEN_KEY,
            'agen_pass' => $this->AGEN_PASS,
            'agen_estado' => $this->AGEN_ESTADO,
            'agen_fecha' => Carbon::parse($this->AGENT_FECHING)->format('Y-m-d H:i:s'),
            'agent_cantidad_asignado' => $this->totalCartera(),
            'cartera' => CarteraResource::collection($this->cartera)
        ];
    }
}
