<?php

namespace App\Http\Controllers\TMoney;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getAccessToken() {
        try {
            $response = getAccessToken();
            $tokenRequest = $response->getBody();
            $json = json_decode($tokenRequest);
            if ($json->access_token == null) {
                return null;
            } else {
                Session::put('access_token', $json->access_token);
                return  response()->json(['error' => false, 'access_token' => $json->access_token]);
            }
        } catch (BadResponseException $e) {
            return $this->responseError($e);
        }

    }

    public function emailCheck($email) {
        try {
            $response = emailCheck($email);
            $body = $response->getBody();
            $json = json_decode($body);
            return response()->json(['error' => false, 'response' => $json]);
        } catch (BadResponseException $e) {
            return $this->responseError($e);
        }
    }
}
