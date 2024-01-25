<?php namespace App\SUtils;

use App\Mail\ManagersFinishReviewingMail;
use Illuminate\Support\Facades\Mail;

class SManagersFinishReviewin {
    
    public static function getMyManagers(){
        return ['Adrián'];
    }

    public static function finishReviewin() {
        $lEmployees = self::getMyManagers();
        Mail::to('adrian.alejandro.aviles@gmail.com')->send(new ManagersFinishReviewingMail($lEmployees));
    }
}