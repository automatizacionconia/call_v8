<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;


    public $user; 
    public $newPassword;   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject =  config('app.name');        

        return $this->from(config('mail.username'),config('app.name'))
            ->subject($subject)
            ->view('web.emails.resetPassword');        
    }
}
