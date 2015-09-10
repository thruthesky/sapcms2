<?php
include 'locations.php';
$location = trim($locations);
$location = str_replace("\r\n", "\n", $location);
$provinces = explode("\n\n", $location);

foreach( $provinces as $place ) {
    $places = explode("\n", $place);
    $province = trim($places[0]);


    echo '$' . "location['$province'] = [\n";

    for ( $i=1; $i < count($places) ; $i ++ ) {
        $city = $places[$i];
        $city = str_ireplace('city', '', $city);
        $city = trim($city);
        echo "\t'" . $city."',\n";
    }

    echo "];\n";

}

