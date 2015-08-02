<?php
use sap\src\Request;

$_SERVER['REQUEST_URI'] = "A=Apple&B=Banana&C=Cake&number=0917-123-4567&home=Manila, Philippines.";
parse_str($_SERVER['REQUEST_URI'], $_GET);
$input = Request::reset();
print_r($input);



$_SERVER['REQUEST_URI'] = "A=AAA&B=BBB&number=0123456789&home=Let's go home now.";
parse_str($_SERVER['REQUEST_URI'], $_GET);
$input = Request::reset();
print_r( $input );



