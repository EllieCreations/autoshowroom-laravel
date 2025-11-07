<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $car; // ✅ Nuovo

    public function __construct($data, $car = null) // ✅ Aggiunto parametro
    {
        $this->data = $data;
        $this->car = $car; // ✅ Nuovo
    }

    public function build()
    {
        return $this->subject('Grazie per averci contattato - AMC-SRLS')
                    ->view('emails.contact-confirmation');
    }
}