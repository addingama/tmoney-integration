<?php

namespace App\Http\Controllers\Api\TMoney;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->client = new Client();
    }

    public function donation(Request $request) {
        try {
            $user = Auth::user();
            $params = [
                'transactionType' => $request['transactionType'],
                'idTmoney' => $user->idTmoney,
                'idFusion' => $user->idFusion,
                'productCode' => $request['productCode'],
                'amount' => $request['amount'],
                'token' => $request['token'],
                'transactionID' => $request['transactionID'],
                'refNo' => $request['refNo'],
                'pin' => $request['pin'],
                'terminal' => Config::get('tmoney.terminal'),
                'apiKey' => Config::get('tmoney.api_key'),
            ];
            // Log::info($params);
            $response = $this->client->post(Config::get('tmoney.base_url').'/donation', [
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
