<?php

namespace App\Listeners\Administrado;

class NewRegisterEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Administrado\NewRegisterCiudadanoEvent',
            'App\Listeners\Administrado\NewRegisterCiudadanoListener@handle'
        );

        $events->listen(
            'App\Events\Administrado\NewRegisterJuridicaEvent',
            'App\Listeners\Administrado\NewRegisterJuridicaListener@handle'
        );

        $events->listen(
            'App\Events\Administrado\NewRegisterOtroEvent',
            'App\Listeners\Administrado\NewRegisterOtroListener@handle'
        );
    }
}
