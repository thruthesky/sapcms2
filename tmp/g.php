<?php

$client = new \GuzzleHttp\Client();
$response = $client->post('http://sapcms2.org/tmp/korean.php');
$code = $response->getStatusCode();
$re = $response->getBody()->getContents();
//$re = json_decode($re, true);
print_r($re);