<?php
include_once "core/etc/phpunit/test.php";
use sap\src\Database;
use sap\src\Entity;
use sap\src\Meta;
class MetaTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }


    public function test_meta_entity_type() {

        /* @todo do entity test */
        /*
        $entity = entity('user')->load('id', 'admin');
        $user = user()->load('id', 'admin');

        $this->assertTrue($entity instanceof Entity);
        $this->assertTrue($user instanceof User);
        */
    }

    public function test_meta_create() {
        $user_meta = new Meta('user');
        $user_meta->createTable();
        $this->assertTrue( Database::load()->tableExists('user_meta') );
        $user_meta->dropTable();
        $this->assertFalse( Database::load()->tableExists('user_meta') );
    }

    public function test_meta_action() {
        $meta = new Meta('test');

        $meta->createTable();

        $meta
            ->set('a','A')
            ->set('b', 'B')
            ->set('c', 'C');
        $this->assertTrue( $meta->getEntity('a') instanceof Entity );
        $this->assertTrue( $meta->get('a') == 'A' );

        $meta->dropTable();
    }

}
