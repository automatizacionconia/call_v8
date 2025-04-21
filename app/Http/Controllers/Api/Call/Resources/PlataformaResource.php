<?php

namespace App\Http\Controllers\Api\Call\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PlataformaResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = array_change_key_case($data, CASE_LOWER);
        return $data;
    }
}
