<?php


namespace App\Services;


use App\Models\OnetimeCode;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailService
{

    /**
     * @param $emailTo
     * @param $subject
     * @param $message
     * @param $messageParams
     * @param string $type
     */
    public function send($emailTo, $subject, $message, $messageParams, $type = 'text')
    {
        Mail::send([$type => $message], $messageParams, function($mes) use ($emailTo, $subject) {
            $mes->to($emailTo)->subject($subject);
            $mes->from(env('MAIL_FROM_ADDRESS'));
        });
    }


    /**
     * @param $subject
     * @param $message
     * @return Exception
     */
    public function notification($subject, $message)
    {
        try {
            $this->send(env('email_notification'), $subject, 'email-notification', ['message' => $message], 'html');
        }catch (Exception $exception){
            return $exception;
        }
    }

}
