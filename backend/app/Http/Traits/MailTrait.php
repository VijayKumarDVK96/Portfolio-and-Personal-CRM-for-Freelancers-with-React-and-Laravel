<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Mail;

trait MailTrait {
    
    function sendmail($view, $data, $to, $to_email, $subject) {
        Mail::send($view, $data, function ($message) {
            $message->to($to_email, $to)
                ->subject($subject);
        });

        if (Mail::failures()) {
            return "Mail not sent";
        } else {
            return "Success";
        }
    }
}
