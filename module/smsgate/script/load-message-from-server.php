<?php

use GuzzleHttp\Client;

$client = new Client();
$res = $client->get('http://sapcms2.org/smsgate/load-a-message', ['auth' =>  ['user', 'pass']]);
echo $res->getBody();