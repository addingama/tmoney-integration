<?php

namespace App\Listeners;

use App\Events\EmailCheck;
use App\Events\SignIn;
use App\Events\SignUp;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EmailCheckListener implements ShouldQueue
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
     * @param  EmailCheck  $event
     * @return void
     */
    public function handle(EmailCheck $event)
    {
        try {
            Log::info('[Listener] EmailCheckListener');
            $response = emailCheck($event->email);
            $body = $response->getBody();
            $json = json_decode($body);
            if ($json->resultCode == 188) {
                // TODO: dispatch signup event
                event(new SignUp($event->email, $event->password, $event->fullname, $event->phone));
            } else {
                // TODO: dispatch login to TMoney
                event(new SignIn($event->email, $event->password));
            }
        } catch (BadResponseException $e) {
            Log::info($e->getMessage());
        }
    }
}
