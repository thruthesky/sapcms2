<?php
use GuzzleHttp\Client;
$client = new Client();
$res = $client->get('http://sap.withcenter.com/smsgate/sender/load');
$body = $res->getBody();
$data = json_decode($body, true);
print_r( $data );
//$res = $client->get("http://sapcms2.org/smsgate/sender/result?mode=success&idx=$data[idx]");
