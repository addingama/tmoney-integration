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