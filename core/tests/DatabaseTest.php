<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Database;
use sap\core\SQL;
use \sap\core\System;
class DatabaseTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function test_default_action() {
        $db = Database::load();

        $db->dropTable('temp');
        $db->createTable('temp');

        $db->addColumn('temp', 'name', 'varchar');
        $db->addColumn('temp', 'mail', 'varchar');
        $db->addColumn('temp', 'birth_year', 'int');
        $db->addColumn('temp', 'no', 'int');


        $db->insert('temp', ['name'=>'JaeHo Song', 'mail'=>'thruthesky@gmail.com', 'birth_year'=>1973]);
        $db->insert('temp', ['name'=>'Mr. Song JaeHo', 'mail'=>'thruthesky@naver.com', 'birth_year'=>1983]);
        $db->insert('temp', ['name'=>'My Old Name?', 'mail'=>'thruthesky@hanmail.net', 'birth_year'=>1993]);


        $this->assertTrue(Database::load()->columnExists('temp', 'idx'));
        $this->assertTrue(Database::load()->columnExists('temp', 'no'));
        $this->assertTrue(Database::load()->columnExists('temp', 'name'));
        if ( $db->type == 'mysql' ) {
            Database::load()->deleteColumn('temp', 'no');
            $this->assertNotTrue(Database::load()->columnExists('temp', 'no'));
        }

    }


}
