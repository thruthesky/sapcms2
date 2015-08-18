<?php

entity(LOCATION)->createTable()
    ->add('province', 'varchar', 64)
    ->add('city', 'varchar', 64)
    ->add('count', 'int unsigned default 0')
    ->unique('province,city');

include 'locations.php';


$location = trim($locations);
//old code : $provinces = explode("\r\n\r\n", $location);-->not working for my computer and dev server
$provinces = explode("\n\n", $location);

//echo count($provinces);
foreach( $provinces as $place ) {
    $places = explode("\n", $place);
    $province = trim($places[0]);
	
    entity(LOCATION)
        ->set('province', strtolower($province))
        ->set('city', '')
        ->save();

    for ( $i=1; $i < count($places) ; $i ++ ) {
        $city = $places[$i];
        $city = str_ireplace('city', '', $city);
        $city = trim($city);
		
				
		entity(LOCATION)
			->set('province', strtolower($province))
			->set('city', strtolower($city))
			->save();
			
		echo $province." - ".$city."\n";	        
    }
}

