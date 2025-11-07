<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $car; 

    public function __construct($data, $car = null) 
    {
        $this->data = $data;
        $this->car = $car; 
    }

    public function build()
    {
        return $this->subject('Nuovo messaggio da ' . $this->data['name'])
                    ->view('emails.contact-notification'); 
    }
}