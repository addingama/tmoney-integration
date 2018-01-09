<?php

namespace App\Listeners;

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
            // TODO: save idTmoney, idFusion to database
            dd($json);
        } catch (BadResponseException $e) {
            Log::info($e->getMessage());
        }
    }
}
