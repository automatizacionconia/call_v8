<?php

namespace App\Channels;
use App\Http\Controllers\Api\Virtual\Models\Parametro;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class MailCustomChannel
{
    public function __construct()
    {
    }
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {   
        
    }
}
