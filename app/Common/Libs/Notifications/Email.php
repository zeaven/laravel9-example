<?php

namespace App\Common\Libs\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $content;

    /**
     * Create a new notification instance.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email');
    }
}
