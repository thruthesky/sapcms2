<?php

entity(LOCATION)->createTable()
    ->add('province', 'varchar', 64)
    ->add('city', 'varchar', 64)
    ->unique('province,city');

include 'locations.php';
$location = trim($locations);
$provinces = explode("\r\n\r\n", $location);
//echo count($provinces);
foreach( $provinces as $place ) {
    $places = explode("\n", $place);
    $province = trim($places[0]);
    for ( $i=1; $i < count($places) ; $i ++ ) {
        $city = $places[$i];
        $city = str_ireplace('city', '', $city);
        $city = trim($city);
        entity(LOCATION)
            ->set('province', $province)
            ->set('city', $city)
            ->save();
        echo '.';
    }
}

