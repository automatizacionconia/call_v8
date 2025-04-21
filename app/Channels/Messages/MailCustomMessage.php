<?php

namespace App\Channels\Messages;

class MailCustomMessage
{
    public $content;

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
}
