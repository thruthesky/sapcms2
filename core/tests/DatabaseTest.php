<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Database;
use sap\core\SQL;
use \sap\core\System;
class DatabaseTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function testDefaults() {
        $db = Database::sqlite(PATH_SQLITE_DATABASE);

        $db->dropTable('temp');
        $db->createTable('temp');

        $db->addColumn('temp', 'name', 'varchar');
        $db->addColumn('temp', 'mail', 'varchar');
        $db->addColumn('temp', 'birth_year', 'int');


        $db->insert('temp', ['name'=>'JaeHo Song', 'mail'=>'thruthesky@gmail.com', 'birth_year'=>1973]);
        $db->insert('temp', ['name'=>'Mr. Song JaeHo', 'mail'=>'thruthesky@naver.com', 'birth_year'=>1983]);
        $db->insert('temp', ['name'=>'My Old Name?', 'mail'=>'thruthesky@hanmail.net', 'birth_year'=>1993]);



        $where = SQL::where()
            ->add('idx', '55', '>')
            ->add('id', 'thru%', 'like')
            ->add(
                SQL::where('OR')
                    ->add('gender', 'M')
                    ->add('birth_year', 1970, '>')
            )
            ->get();



    }


}
