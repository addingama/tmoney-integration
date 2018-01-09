<?php

namespace App\Listeners;

use App\Events\SignIn;
use App\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
            // TODO: save idTmoney, idFusion to database. save token to session
            $user = User::where('email', '=', $event->email)->first();
            if ($user) {
                $user->update([
                    'idTmoney' => $json->user->idTmoney,
                    'idFusion' => $json->user->idFusion
                ]);
                Session::put('tmoney_token', $json->user->token);
                Session::put('tmoney_token_expire', $json->user->tokenExpiry);
            }
        } catch (BadResponseException $e) {
            Log::info($e->getMessage());
        }
    }
}
