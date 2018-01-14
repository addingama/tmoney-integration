<?php

namespace App\Http\Controllers\Api\TMoney;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->client = new Client();
    }

    public function changePin(Request $request) {
        try {
            $user = Auth::user();
            $params = [
                'idTmoney' => $user->idTmoney,
                'idFusion' => $user->idFusion,
                'token' => $request['token'],
                'old_pin' => $request['old_pin'],
                'new_pin' => $request['new_pin'],
                'terminal' => Config::get('tmoney.terminal'),
                'apiKey' => Config::get('tmoney.api_key'),
            ];
            Log::info($params);
            $response = $this->client->post(Config::get('tmoney.base_url') . '/change-pin', [
                'headers' => [
                    'Authorization' => Config::get('tmoney.authorization'),
                    'Accept' => 'application/json'
                ],
                'form_params' => $params
            ]);
            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }
    }

    public function resetPin(Request $request) {
        try {
            $user = Auth::user();
            $params = [
                'idTmoney' => $user->idTmoney,
                'idFusion' => $user->idFusion,
                'token' => $request['token'],
                'terminal' => Config::get('tmoney.terminal'),
                'apiKey' => Config::get('tmoney.api_key'),
            ];
            Log::info($params);
            $response = $this->client->post(Config::get('tmoney.base_url') . '/reset-pin', [
                'headers' => [
                    'Authorization' => Config::get('tmoney.authorization'),
                    'Accept' => 'application/json'
                ],
                'form_params' => $params
            ]);
            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }
    }
}
