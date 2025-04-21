<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\Call\Models\Call;
use App\Http\Controllers\Api\Call\Models\CallTranscript;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class DescargarLlamadas extends Command
{
    protected $signature = 'notificaciones:descargar';
    protected $description = 'Descarga llamadas realizadas por los agentes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $apiUrl = 'https://api.retellai.com/v2/list-calls';
        $apiKey = 'key_c05bc5a5c71378470feb215a5960';

        try {
            $client = new Client([
                'verify' => false,
                'timeout' => 30,
            ]);
            
            $response = $client->post($apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'sort_order' => 'descending',
                    //'limit' => 50,
                    'filter_criteria' => [
                        'agent_id' => []
                    ]
                ],
            ]);
        
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $callData = json_decode($response->getBody(), true);

            foreach ($callData as $call) {

                if (Call::where('call_id', $call['call_id'])->exists()) {
                    continue;
                }
                $audioPath = null;
                $fileName = null;
                if (!empty($call['recording_url'])) {
                    try {
                        $audioContent = Http::get($call['recording_url'])->body();
                        if (empty($audioContent)) {
                            throw new \Exception("El contenido del audio está vacío.");
                        }
                        $fileName = "call_" . $call['call_id'] . ".wav";
                        $filePath = "file/" . $fileName;
                        Storage::disk('public')->put($filePath, $audioContent);
                        $audioPath = $filePath;
                    } catch (\Exception $e) {
                        Log::error("Error al descargar audio de llamada {$call['call_id']}: " . $e->getMessage());
                    }
                }
                $callModel = Call::create([
                    'call_id'          => $call['call_id'],
                    'call_type'        => $call['call_type'],
                    'agent_id'         => $call['agent_id'],
                    'call_status'      => $call['call_status'],
                    'start_timestamp'  => $call['start_timestamp'],
                    'end_timestamp'    => $call['end_timestamp'],
                    'date_start_format'=> Carbon::createFromTimestampMs($call['start_timestamp'])->format('Y-m-d H:i:s'),
                    'date_end_format'  => Carbon::createFromTimestampMs($call['end_timestamp'])->format('Y-m-d H:i:s'),
                    'duration_ms'      => $call['duration_ms'],
                    'transcript'       => $call['transcript'] ?? null,
                    'recording_url'    => $fileName,
                    'from_number'      => $call['from_number'] ?? null,
                    'to_number'        => $call['to_number'] ?? null,
                    'direction'        => $call['direction'] ?? null,
                ]);
            
                if (!empty($call['transcript_object'])) {
                    foreach ($call['transcript_object'] as $transcript) {
                        CallTranscript::create([
                            'call_id' => $call['call_id'],
                            'role'    => $transcript['role'],
                            'content' => $transcript['content'],
                        ]);
                    }
                }
            
            }

        } catch (\Exception $e) {
            $this->error('Error en la descarga: ' . $e->getMessage());
        }
    }
}
