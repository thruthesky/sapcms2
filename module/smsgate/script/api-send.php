<?php


use GuzzleHttp\Client;

$client = new Client();
$res = $client->get('http://sapcms2.org/smsgate/api?id=admin&password=1234&method=sendSms&number=0917-467-8603&message=hello, how are you?', ['verify' => false]);
$body = $res->getBody();

$re = json_decode($body, true);

print_r($re);







