<?php

namespace App\Services;

class NotificacionAlertaService
{

    public function notificar(array $notificacion)
    {

        $endPoint = config('services.notificacion.endpoint');

        try {
            $client = new \GuzzleHttp\Client();

            $requestContent = [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ],
                'json' => $notificacion
            ];
            
            $response = $client->request('POST', $endPoint, $requestContent);

            $response = json_decode($response->getBody());

            return $response;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            // dd($e->getMessage());
            report($e);
            throw new \Exception('El servicio de whatsapp no esta respondiendo, por favor intente dentro de unos minutos ', $e->getMessage());
        } catch (\Exception $e) {
            report($e);
            throw new \Exception($e->getMessage());
        }
    }
}