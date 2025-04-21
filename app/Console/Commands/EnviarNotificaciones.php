<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EnviarNotificaciones extends Command
{
    protected $signature = 'notificaciones:enviar';
    protected $description = 'Envía notificaciones a los clientes según la programación';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            $horaActual = Carbon::now()->format('H:i');
            $diaActual = Carbon::now()->dayOfWeekIso; // 1 (Lunes) - 7 (Domingo)

            $programaciones = DB::table('CALLCENTER.PROGRAMACION as p')
                ->join('CALLCENTER.GRUPO as g', 'p.GRUP_CODIGO', '=', 'g.GRUP_CODIGO')
                ->join('CALLCENTER.CARTERA as c', 'g.GRUP_CODIGO', '=', 'c.GRUP_CODIGO')
                ->join('CALLCENTER.CLIENTES as cl', 'c.CLIE_CODIGO', '=', 'cl.CLIE_CODIGO')
                ->select(
                    'c.CART_CODIGO',
                    'cl.CLIE_CODIGO',
                    'cl.CLIE_NOMBRES',
                    'cl.CLIE_CELULAR',
                    'cl.CLIE_DEUDA',
                    'cl.CLIE_SUSCRIPTOR',
                    'cl.CLIE_CUENTA',
                    'cl.CLIE_CEDULA',
                    'p.PROG_HORA',
                    'p.PROG_DIA'
                )
                ->where('p.PROG_DIA', $diaActual)
                #->where('p.PROG_HORA', '<=', $horaActual)
                ->whereRaw('TO_CHAR("p"."PROG_HORA", \'HH24:MI\') = ?', [$horaActual])
                ->where('p.PROG_ESTADO', 1)
                ->where('c.C_ESTA_CODIGO', 1)
                ->get();

            if ($programaciones->isEmpty()) {
                $this->info('No hay notificaciones para enviar en este momento.');
                return;
            }

            $data = [];
            $carterasActualizadas = [];
            foreach ($programaciones as $cliente) {
                $data[] = [
                    'celular' => $cliente->CLIE_CELULAR,
                    'nombre'  => $cliente->CLIE_NOMBRES,
                    'cuenta'  => $cliente->CLIE_CUENTA,
                    'cedula'  => $cliente->CLIE_CEDULA,
                    'suscriptor' => $cliente->CLIE_SUSCRIPTOR,
                    'monto'   => $cliente->CLIE_DEUDA,
                ];
                $carterasActualizadas[] = $cliente->CART_CODIGO;
            }

            $data = ['clientes' => $data];
            Log::info("Data: " . json_encode($data));
            #return;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->withOptions(['verify' => false])
            #->post('https://n8n-n8n-start.tmwtz1.easypanel.host/webhook-test/d05b0f5d-a5bc-4972-8cca-98eada3e8b20', $data); //
            ->post('https://hook.us1.make.com/gt9j78jicknr14ec0j3jtn9n7ryhieqx', $data); //retell
           # ->post('https://hook.us1.make.com/8rckip6qi6rl9rtzms6av8alxbzvq4w7', $data); //vapi

            $respuestaTexto = trim($response->body());

            Log::info("Respuesta de la API: " . $respuestaTexto);

            if ($response->successful() || $response->status() == 204 || $respuestaTexto === "Accepted") {
                $this->info("Mensajes enviados correctamente.");

                DB::table('CALLCENTER.CARTERA')
                ->whereIn('CART_CODIGO', $carterasActualizadas)
                ->update([
                    'CART_FECHENVIO' => Carbon::now(),
                    'C_ESTA_CODIGO'   => 2
                ]);
                Log::info("Carteras actualizadas correctamente.");
            } else {
                Log::error("Error al enviar mensajes." . $respuestaTexto);
                $this->error("Error al enviar datos a la API.");
            }
            
        } catch (\Exception $e) {
            Log::error("Error en EnviarNotificaciones: " . $e->getMessage());
        }
    }
}
