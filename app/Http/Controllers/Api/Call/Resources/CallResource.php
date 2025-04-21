<?php

namespace App\Http\Controllers\Api\Call\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CallResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'agent_id' => $this->agent_id,
            'call_id' => $this->call_id,
            'call_status' => $this->call_status,
            'call_type' => $this->call_type,
            'created_at' => $this->created_at,
            'date_end_format' => $this->date_end_format,
            'date_start_format' => $this->date_start_format,
            'direction' => $this->direction,
            'duration_ms' => $this->duration_ms,
            'end_timestamp' => $this->end_timestamp,
            'from_number' => $this->from_number,
            'recording_url' => $this->recording_url_full,
            'start_timestamp' => $this->start_timestamp,
            'to_number' => $this->to_number,
            'transcript' => $this->transcript,
            'updated_at' => $this->updated_at,
        ];
    }
}
