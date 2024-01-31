<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManagersEvalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$lastname,$year)
    {
       $this->name = $name;
       $this->lastname = $lastname; 
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
                        ->view('mails.ManagersEvalMail')->with('name',$this->name)->with('lastname',$this->lastname)->with('year',$this->year);
    }
}
