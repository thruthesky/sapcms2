<?php

$client = new \GuzzleHttp\Client([
    'defaults' => [
    ],
]);


$jar = new \GuzzleHttp\Cookie\CookieJar;

$response = $client->post("https://ssl.olx.ph/account/?ref%5B0%5D%5Baction%5D=myaccount&ref%5B0%5D%5Bmethod%5D=index", [
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


$url = "http://olx.ph/item/affordable-units-a7-s3-s4-s5-note-2-note-3-note-4-s6-edge-g2-g3-flex-ID6QfIV.html?p=1#d87ad13fbe";
$response = $client->get($url, [
    'cookies' => $jar,
    'headers'         => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
    ],
    'verify' => false,
]);
print_r($response->getBody()->getContents());
sleep(1);



$url = "http://olx.ph/item/affordable-units-a7-s3-s4-s5-note-2-note-3-note-4-s6-edge-g2-g3-flex-ID6QfIV.html?p=1#d87ad13fbe";
$response = $client->get($url, [
    'cookies' => $jar,
    'headers'         => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
    ],
    'verify' => false,
]);
print_r($response->getBody()->getContents());
sleep(1);



$url = "http://olx.ph/item/affordable-units-a7-s3-s4-s5-note-2-note-3-note-4-s6-edge-g2-g3-flex-ID6QfIV.html?p=1#d87ad13fbe";
$response = $client->get($url, [
    'cookies' => $jar,
    'headers'         => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
    ],
    'verify' => false,
]);
print_r($response->getBody()->getContents());
sleep(1);

