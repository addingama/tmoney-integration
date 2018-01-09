<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

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
            'apiKey' => Config::get('tmoney.api_key')
        ]
    ]);
}