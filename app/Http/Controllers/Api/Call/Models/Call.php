<?php
namespace App\Http\Controllers\Api\Call\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Call extends Model
{
    protected $table = 'CALLCENTER.calls';
    protected $primaryKey = 'id';

    protected $fillable = [
        'call_id',
        'call_type',
        'agent_id',
        'call_status',
        'start_timestamp',
        'end_timestamp',
        'date_start_format',
        'date_end_format',
        'duration_ms',
        'recording_url',
        'from_number',
        'to_number',
        'direction',
        'transcript',
    ];
    protected $appends = ['recording_url_full'];

    public function transcripts()
    {
        return $this->hasMany(CallTranscript::class);
    }

    public function getRecordingUrlFullAttribute()
    {
        return $this->recording_url 
            ? Storage::disk('file')->url($this->recording_url)
            : null;
    }
}
