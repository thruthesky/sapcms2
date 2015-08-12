<?php

use GuzzleHttp\Client;

$client = new Client();
$res = $client->get('http://sapcms2.org/smsgate/sender/load');
$data = json_decode($res->getBody(), true);

$res = $client->get("http://sapcms2.org/smsgate/sender/result?mode=success&idx=$data[idx]");


