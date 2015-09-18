<?php


use GuzzleHttp\Client;

$client = new Client();
$tag = "sonub.[sender-idx].date[YYMMDDHHIISS]";
$res = $client->get("http://sap.withcenter.com/smsgate/api?id=admin&password=1234&method=sendSms&tag=$tag&number=0917-467-8603&message=hello, how are you?&priority=9");
$body = $res->getBody();

echo $body->getContents();


//$re = json_decode($body, true);

//print_r($re);







