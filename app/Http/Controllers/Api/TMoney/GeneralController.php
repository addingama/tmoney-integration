<?php

namespace App\Http\Controllers\Api\TMoney;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getAccessToken(Request $request) {
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
            return $this->responseError($request, $e);
        }

    }

    public function emailCheck(Request $request, $email) {
        try {
            $response = emailCheck($email);
            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }
    }

    public function emailVerification(Request $request, $activationCode) {
        try {
            $response = emailVerification($activationCode);
            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }
    }

    public function myProfile(Request $request) {
        try {
            $response = myProfile($request['idTmoney'], $request['idFusion'], $request['token']);
            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }
    }

    public function getProduct(Request $request) {
        try {
            $response = $this->client->post(Config::get('tmoney.base_url').'/get-product', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'form_params' => [
                    'id' => $request['id'],
                    'name' => $request['name'],
                    'type' => $request['type'],
                ]
            ]);

            $body = $response->getBody();
            $json = json_decode($body);
            return $this->responseSuccess($request, $json);
        } catch (BadResponseException $e) {
            return $this->responseError($request, $e);
        }


        dd($json);

    }
}
