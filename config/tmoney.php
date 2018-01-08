<?php
/**
 * Created by PhpStorm.
 * User: gama
 * Date: 06/01/18
 * Time: 20.33
 */

$production =  "https://prodapi-app.tmoney.co.id/api";
$sandbox = "https://api-sandbox-app.tmoney.co.id/api";
$accessTokenProduction = "T-MONEY_cc80ada3203052d4e5fe44678a981d88";
$accessTokenSandbox = "T-MONEY_PUBLICKEYSANDBOX";

$mainapiSandbox = "https://api.mainapi.net/tmoney/1.0.0-sandbox";

return [
    'base_url' => $sandbox,
    'terminal' => 'MAINAPI-TEST', // get your own production terminal by contacting tmoney representative
    'api_key' => $accessTokenSandbox,
    'private_key' => $accessTokenSandbox,
    'authorization' => 'Basic WjZmd3hXMHpsTVdhUXp0d3hnSTdKUlFOMzlJYTpTWTRtdExVOHdibjB6YlQwRThoTkN3VUNuYTRh'
];
