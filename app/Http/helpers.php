<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: gama
 * Date: 06/01/18
 * Time: 20.58
 */

function getAccessToken() {
    $client = new Client();
    return $client->post('https://api.mainapi.net/token', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization')
        ],
        'form_params' => [
            'grant_type' => 'client_credentials'
        ]
    ]);
}


function emailCheck($email) {
    $client = new Client();
    return $client->post(Config::get('tmoney.base_url').'/email-check', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization'),
            'Accept' => 'application/json'
        ],
        'form_params' => [
            'userName' => $email,
            'terminal' => Config::get('tmoney.terminal'),
            'apiKey' => Config::get('tmoney.api_key')
        ]
    ]);
}

function signUp($accType, $email, $password, $fullname, $phone) {
    $client = new Client();
    return $client->post(Config::get('tmoney.base_url').'/sign-up', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization'),
            'Accept' => 'application/json'
        ],
        'form_params' => [
            'accType' => $accType,
            'userName' => $email,
            'password' => $password,
            'fullName' => $fullname,
            'phoneNo' => $phone,
            'terminal' => Config::get('tmoney.terminal'),
            'apiKey' => Config::get('tmoney.api_key')
        ]
    ]);
}

function emailVerification($activationCode) {
    $client = new Client();
    return $client->post(Config::get('tmoney.base_url').'/email-verification', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization'),
            'Accept' => 'application/json'
        ],
        'form_params' => [
            'code' => $activationCode,
            'terminal' => Config::get('tmoney.terminal'),
            'apiKey' => Config::get('tmoney.api_key')
        ]
    ]);
}

function signIn($email, $password) {
    $client = new Client();
    return $client->post(Config::get('tmoney.base_url').'/sign-in', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization'),
            'Accept' => 'application/json'
        ],
        'form_params' => [
            'userName' => $email,
            'password' => $password,
            'terminal' => Config::get('tmoney.terminal'),
            'apiKey' => Config::get('tmoney.api_key'),
            'signature' => tmoney_signature($email)
        ]
    ]);
}

function myProfile($idTmoney, $idFusion, $token) {
    $client = new Client();
    return $client->post(Config::get('tmoney.base_url').'/my-profile', [
        'headers' => [
            'Authorization' => Config::get('tmoney.authorization'),
            'Accept' => 'application/json'
        ],
        'form_params' => [
            'idTmoney' => $idTmoney,
            'idFusion' => $idFusion,
            'token' => $token,
            'terminal' => Config::get('tmoney.terminal'),
            'apiKey' => Config::get('tmoney.api_key'),
        ]
    ]);
}

function tmoney_signature($email, $phoneNo = '')
{
    $params = [
        'username' => $email,
        'dateTime' => $phoneNo,
        'terminal' => Config::get('tmoney.terminal'),
        'apiKey' => Config::get('tmoney.api_key'),
    ];
    $signature = implode('', $params);
    return sha256($signature);
}

function sha256($string)
{
    $result = hash_hmac('sha256', $string, Config::get('tmoney.private_key'), false);
    return urlencode($result);
}