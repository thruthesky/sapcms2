<?php
include_once "core/etc/phpunit/test.php";
use sap\src\Database;
use sap\src\Entity;
use sap\src\Meta;
class MetaTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function test_meta_create() {
        $user_meta = new Meta('user');
        $user_meta->install();
        $this->assertTrue( Database::load()->tableExists('user_meta') );
        $user_meta->unInstall();
        $this->assertFalse( Database::load()->tableExists('user_meta') );
        $user_meta->unInstall();
    }

    public function test_meta_action() {
        $meta = new Meta('test');

        $meta->install();

        $meta
            ->set('a','A')
            ->set('b', 'B')
            ->set('c', 'C');
        $this->assertTrue( $meta->getEntity('a') instanceof Entity );
        $this->assertTrue( $meta->get('a') == 'A' );

        $meta
            ->set('hi.ace', 'car')
            ->set('hi.there', 'hadein')
            ->set('hi.toeic', 'helloopic');

        $row = $meta->group('hi');
        $this->assertTrue( count($row) == 3 );


        $meta->unInstall();
    }

}
