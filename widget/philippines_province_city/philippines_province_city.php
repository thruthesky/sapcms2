<?php
use sap\src\Response;
add_javascript();
include_once 'location.php';

if ( request('widget') && $province = request('province') ) {
    display_city($location, request('province'));
}
else {
    display_province_city($location, login('province'), login('city'));
}

function display_province_city($location, $my_province, $my_city) {
    display_province($location, $my_province);
    display_city($location, $my_province, $my_city);
}
function display_province($location, $my_province) {	
    if ( $my_province ) {
        $province = array_keys($location);
        foreach( $province as $p ) {
            $ps[$p] = $p;
        }
        $select = html_select([
            'name' => 'province',
            'options' => $ps,
            'default' => login('province')
        ]);
        echo html_row([
            'caption' => 'Province',
            'class' => 'province',
            'text' => $select,
        ]);
    }
}
function display_city($location, $my_province, $my_city=null) {	
	if( empty( $my_province ) ) return;
    $cities = $location[$my_province];
    foreach( $cities as $p ) {
        $ps[$p] = $p;
    }
    $select = html_select([
        'name' => 'city',
        'options' => $ps,
        'default' => $my_city,
    ]);
    echo html_row([
        'caption' => 'City',
        'class' => 'city',
        'text' => $select,
    ]);
}