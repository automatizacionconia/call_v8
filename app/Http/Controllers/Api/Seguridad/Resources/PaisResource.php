<?php

namespace App\Http\Controllers\Api\Seguridad\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PaisResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = array_change_key_case($data, CASE_LOWER);
        return $data;
    }
}
