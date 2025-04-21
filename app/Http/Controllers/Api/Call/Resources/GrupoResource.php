<?php

namespace App\Http\Controllers\Api\Call\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class GrupoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'grup_codigo' => $this->GRUP_CODIGO,
            'grup_nombre' => $this->GRUP_NOMBRE,
            'grup_estado' => $this->GRUP_ESTADO,
            'programaciones' => ProgramacionResource::collection($this->programaciones),
        ];
    }
}
