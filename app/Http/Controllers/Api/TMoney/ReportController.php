<?php

namespace App\Http\Controllers\Api\TMoney;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->client = new Client();
    }

    public function transactionReport(Request $request)
    {
        try {
            $user = Auth::user();
            $params = [
                'idTmoney' => $user->idTmoney,
                'idFusion' => $user->idFusion,
                'token' => $request['token'],
                'startDate' => $request['startDate'],
                'stopDate' => $request['stopDate'],
                'limit' => $request['limit'],
                'terminal' => Config::get('tmoney.terminal'),
                'apiKey' => Config::get('tmoney.api_key'),
            ];
            Log::info($params);
            $response = $this->client->post(Config::get('tmoney.base_url') . '/transaction-report', [
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
