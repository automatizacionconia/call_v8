<?php
namespace App\Http\Controllers\Api\Call\Models;

use Illuminate\Database\Eloquent\Model;

class CallTranscript extends Model
{
    protected $table = 'CALLCENTER.call_transcripts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'call_id',
        'role',
        'content',
    ];

    public function call()
    {
        return $this->belongsTo(Call::class);
    }
}
