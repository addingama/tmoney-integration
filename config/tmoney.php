<?php
/**
 * Created by PhpStorm.
 * User: gama
 * Date: 06/01/18
 * Time: 20.33
 */

$production =  "https://prodapi-app.tmoney.co.id/api/";
$sandbox = "https://api-sandbox-app.tmoney.co.id/api/";
$accessTokenProduction = "T-MONEY_3aa121a55392956bad9b5af0927b8e18";
$accessTokenSandbox = "T-MONEY_PUBLICKEYSANDBOX";


return [
    'base_url' => $sandbox,
    'terminal' => 'MAINAPI-TEST', // get your own production terminal by contacting tmoney representative
    'api_key' => $accessTokenSandbox,
    'private_key' => $accessTokenSandbox,
    'authorization' => 'Basic RUJ6eUJrdENIdTBnQnVBcEhjbmVqYXpEUjVjYTo1X0gybG83aUZZZFl4Nzh3TTRlMEs4SFNaNFlh'
];