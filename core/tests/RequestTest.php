<?php

use sap\src\Request;

class RequestTest extends PHPUnit_Framework_TestCase {
    public function test_input() {

        $_SERVER['REQUEST_URI'] = "A=Apple&B=Banana&C=Cake&number=0917-123-4567&home=Manila, Philippines.";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        $input = Request::reset();
        $this->assertTrue( count($input) == 5 );
        $this->assertTrue( Request::get('A') == 'Apple' );


        $_SERVER['REQUEST_URI'] = "A=AAA&B=BBB&number=0123456789&home=Let's go home now.";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        $input = Request::reset();
        $this->assertTrue( count($input) == 4 );
        $this->assertTrue( Request::get('B') == 'BBB' );


    }

}