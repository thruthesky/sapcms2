<?php

$client = new \GuzzleHttp\Client([
    'defaults' => [
    ],
]);


$jar = new \GuzzleHttp\Cookie\CookieJar;


// LOGIN
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

$urls = [];
$urls[] = "http://olx.ph/item/cloudfone-android-phone-ID6Sg6T.html?p=7#d87ad13fbe";
$urls[] = "http://olx.ph/item/cloudfone-android-phone-ID50aOX.html#d87ad13fbe";
$urls[] = "http://olx.ph/item/3-5-cloudfone-androidtv-mobile-ID6OQXO.html#d87ad13fbe";
foreach ( $urls as $url ) {
    $response = $client->get($url, [
        'cookies' => $jar,
        'headers'         => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 Safari/537.36',
        ],
        'verify' => false,
    ]);
    print_r($response->getBody()->getContents());
    sleep(1);
}


