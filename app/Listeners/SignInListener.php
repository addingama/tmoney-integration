<?php

namespace App\Listeners;

use App\Events\SignIn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SignInListener
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
     * @param  SignIn  $event
     * @return void
     */
    public function handle(SignIn $event)
    {
        try {
            Log::info('[Listener] SignInListener');
            $response = signIn(
                $event->email,
                $event->password);
            $body = $response->getBody();
            $json = json_decode($body);
            // TODO: save idTmoney, idFusion to database
            dd($json);
        } catch (BadResponseException $e) {
            Log::info($e->getMessage());
        }
    }
}
