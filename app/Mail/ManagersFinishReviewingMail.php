<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManagersFinishReviewingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$lastname,$year,$evaluated)
    {
       $this->name = $name;
       $this->lastname = $lastname; 
       $this->year = $year;
       $this->evaluated = $evaluated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = "evaluaciondesempeno@aeth.mx";
        return $this->from($email)
                        ->subject('Evaluación de desempeño')
                        ->view('mails.ManagersFinishReviewingMail')->with('name',$this->name)->with('lastname',$this->lastname)->with('year',$this->year)->with('evaluated',$this-evaluated);
    }
}
