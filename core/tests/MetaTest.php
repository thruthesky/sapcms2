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


    public function test_meta_group() {
        meta('z')->createTable();
        meta('z')->group('meal')->set('breakfast', 'fruits and milk', 10);
        meta('z')->group('meal')->set('lunch', 'beef and milk', 20);
        meta('z')->group('meal')->set('dinner', 'bread and milk', 30);

        $this->assertTrue( count(meta('z')->group('meal')->gets()) == 3 );
        $this->assertTrue( meta('z')->group('meal')->get('lunch') == 'beef and milk' );

        meta('z')->group('meal')->delete();
        $this->assertTrue( count(meta('z')->group('meal')->gets()) == 0 );


        meta('z')->group('user')->group('jaeho')->set('name', 'JaeHo Song');
        meta('z')->group('user')->group('jaeho')->set('age', '41');
        meta('z')->group('user')->group('jaeho')->set('gender', 'M');
        meta('z')->group('user')->group('jaeho')->set('address', 'Balibago');

        meta('z')->group('user')->group('woobum')->set('name', 'Woo Beom Jung');
        meta('z')->group('user')->group('woobum')->set('age', '39');
        meta('z')->group('user')->group('woobum')->set('gender', 'M');
        meta('z')->group('user')->group('woobum')->set('address', 'Balibago');



        $this->assertTrue( count(meta('z')->group('user')->gets()) == 8 );
        $this->assertTrue( count(meta('z')->group('user')->group('jaeho')->gets()) == 4 );

        $this->assertTrue( meta('z')->group('user')->group('woobum')->get('age') == 39 );



        meta('z')->group('user')->group('woobum')->delete();
        $this->assertTrue( count(meta('z')->group('user')->group('woobum')->gets()) == 0 );
        $this->assertTrue( count(meta('z')->group('user')->group('jaeho')->gets()) == 4 );
        $this->assertTrue( count(meta('z')->group('user')->gets()) == 4 );

        meta('z')->group('user')->delete();
        $this->assertTrue( count(meta('z')->group('user')->group('jaeho')->gets()) == 0 );
        $this->assertTrue( count(meta('z')->group('user')->gets()) == 0 );


        /**
         *
         * @note code will be generated like below.
         *
         * user.thruthesky.name
         * user.thruthesky.property.callcenter
         * user.thruthesky.property.site
         * user.thruthesky.property.consultancy
         */
        meta('z')
            ->group('user')
            ->group('thruthesky')
            ->set('name', 'thruthesky')
                ->group('property')
                ->set('callcenter', 'angles')
                ->set('site', 'philgo')
                ->set('consultancy', 'viy');

        $this->assertTrue( count(meta('z')->group('user')->group('thruthesky')->gets()) == 4 );
        $this->assertTrue( count(meta('z')->group('user')->group('thruthesky')->group('property')->gets()) == 3 );
        $this->assertTrue( meta('z')->group('user')->group('thruthesky')->group('property')->get('site') == 'philgo' );


        meta('z')->group('user')->delete();

        meta('z')->dropTable();

    }

}
