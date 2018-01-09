<?php

namespace App\Listeners;

use App\Events\SignIn;
use App\Events\SignUp;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SignUpListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SignUp  $event
     * @return void
     */
    public function handle(SignUp $event)
    {
        try {
            Log::info('[Listener] SignUpListener');
            $response = signUp(1,
                $event->email,
                $event->password,
                $event->fullname,
                $event->phone);
            $body = $response->getBody();
            $json = json_decode($body);
            // TODO: save idTmoney, idFusion to database and dispatch email verification
            if ($json->resultCode == 0) {
                // TODO: call email verification helper
                $verificationResponse = emailVerification($json->activationCode);
                $verificationBody = $verificationResponse->getBody();
                $verificationJson = json_decode($verificationBody);
                if ($verificationJson->resultCode == 0) {
                    event(new SignIn($event->email, $event->password));
                }
            }
        } catch (BadResponseException $e) {
            Log::info($e->getMessage());
        }
    }
}
