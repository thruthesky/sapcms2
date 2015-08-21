<?php

$client = new \GuzzleHttp\Client([
    'defaults' => [
    ],
]);


$jar = new \GuzzleHttp\Cookie\CookieJar;
//https://ssl.olx.ph/account/?ref%5B0%5D%5Baction%5D=myaccount&ref%5B0%5D%5Bmethod%5D=index

$response = $client->post("https://ssl.olx.ph/account/", [
//$response = $client->post("http://work.org/phpinfo.php", [
//$response = $client->post("http://work.org:8080/", [

    'form_params' => [
        'login[email_phone]' => "09157777369",
        'login[password]' => "BF57",
    ],
    'cookies' => $jar,
    'headers'         => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
    ],
    'verify' => false,
]);


// print_r($response->getBody()->getContents());
$row = [];

$url = "http://olx.ph/item/video-card-ID6So7U.html";
$response = $client->get($url, [
    'cookies' => $jar,
    'headers'         => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
    ],
    'verify' => false,
]);
echo $response->getBody()->getContents();
sleep(1);
