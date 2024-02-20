<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManagersApproveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($year)
    {
       $this->year = $year;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = "adrian.aviles.swaplicado@gmail.com";
        return $this->from($email)
                        ->subject('Evaluación de desempeño')
                        ->view('mails.ManagersApproveMail')->with('year',$this->year);
    }
}