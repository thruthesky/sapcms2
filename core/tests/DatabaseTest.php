<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Database;
use sap\core\SQL;
use \sap\core\System;
class DatabaseTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }


    public function test_table_exits() {
        $table = 'test_table';
        $db = Database::load();
        $db->dropTable($table);

        $this->assertFalse($db->tableExists($table));

        $db->createTable($table);
        $this->assertTrue($db->tableExists($table));

        Database::load()->dropTable($table);
    }


    public function test_table_field_exits() {
        $table = 'test_table';
        $db = Database::load();
        $db->dropTable($table);

        $this->assertFalse($db->columnExists($table, 'idx'));

        $db->createTable($table);
        $this->assertTrue($db->tableExists($table));

        Database::load()->dropTable($table);
    }


    public function test_default_action() {
        $db = Database::load();

        $db->dropTable('temp');
        $db->createTable('temp');

        $db->addColumn('temp', 'name', 'varchar');
        $db->addColumn('temp', 'mail', 'varchar');
        $db->addColumn('temp', 'birth_year', 'int');
        $db->addColumn('temp', 'no', 'int');

        $idx1 = $db->insert('temp', ['name'=>'JaeHo Song', 'mail'=>'thruthesky@gmail.com', 'birth_year'=>1973]);
        $idx2 = $db->insert('temp', ['name'=>'Mr. Song JaeHo', 'mail'=>'thruthesky@naver.com', 'birth_year'=>1983]);
        $idx3 = $db->insert('temp', ['name'=>'My Old Name?', 'mail'=>'thruthesky@hanmail.net', 'birth_year'=>1993]);

        $this->assertTrue($idx1 > 0);
        $this->assertTrue($idx2 > 0);
        $this->assertTrue($idx3 > 0);

        $this->assertTrue(Database::load()->columnExists('temp', 'idx'));
        $this->assertTrue(Database::load()->columnExists('temp', 'no'));
        $this->assertTrue(Database::load()->columnExists('temp', 'name'));

        if ( $db->type == 'mysql' ) {
            Database::load()->deleteColumn('temp', 'no');
            $this->assertNotTrue(Database::load()->columnExists('temp', 'no'));
        }


        $row = $db->row('temp', "name='JaeHo Song'");
        $this->assertNotEmpty($row);
        $this->assertTrue($row['mail'] == 'thruthesky@gmail.com');


        $row = $db->row('temp', db_cond('name','JaeHo Song'));
        $this->assertNotEmpty($row);
        $this->assertTrue($row['mail'] == 'thruthesky@gmail.com');


        $db->dropTable('abc');
        $db->createTable('abc');
        $db->addColumn('abc', 'a', 'varchar');
        $db->addColumn('abc', 'b', 'varchar');
        $db->addColumn('abc', 'c', 'varchar');

        $db->insert('abc', ['a'=>'A', 'b'=>'B', 'c'=>'C']);
        $db->insert('abc', ['a'=>'ABC', 'b'=>'BCD', 'c'=>'CDE']);
        $db->insert('abc', ['a'=>'1', 'b'=>'2', 'c'=>'3']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'banana', 'c'=>'cherry']);

        $db->row('abc',
            db_cond('a', 'A%', 'like')
            ->condition(
                db_or()
                ->condition(
                    db_and()
                        ->condition('b', 'B%', 'like')
                        ->condition('c', 'C%', 'like')
                )
                ->condition(
                    db_and()
                        ->condition('b', 'B')
                        ->condition('c', 'C')
                )
            )
        );


        $db->insert('abc', ['a'=>'Airplane', 'b'=>'Boat', 'c'=>'Cruze']);
        $row = $db->row('abc',  "b='Boat'");
        $this->assertTrue($row['a'] == 'Airplane');
        $db->delete('abc', "b='Boat'");
        $row = $db->row('abc',  "b='Boat'");
        $this->assertEmpty($row);


        $db->dropTable('temp');
        $db->dropTable('abc');
    }



    public function test_row()
    {
        $db = Database::load();
        $db->dropTable('abc');
        $db->createTable('abc');
        $db->addColumn('abc', 'a', 'varchar');
        $db->addColumn('abc', 'b', 'varchar');
        $db->addColumn('abc', 'c', 'varchar');

        $db->insert('abc', ['a'=>'A', 'b'=>'B', 'c'=>'C']);
        $db->insert('abc', ['a'=>'ABC', 'b'=>'BCD', 'c'=>'CDE']);
        $db->insert('abc', ['a'=>'1', 'b'=>'2', 'c'=>'3']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'banana', 'c'=>'cherry']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'beach', 'c'=>'city']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'box', 'c'=>'cake']);

        $this->assertNotEmpty($db->row('abc'));
        $this->assertNotEmpty($db->row('abc', "1 LIMIT 0,1"));
        $this->assertNotEmpty($db->row('abc', "LIMIT 1,1"));
        $this->assertNotEmpty($db->row('abc', "ORDER BY idx ASC LIMIT 2,1"));
        $this->assertNotEmpty($db->row('abc', null, 'idx, a'));
        $this->assertNotEmpty($db->row('abc', "A LIKE 'A%' ORDER BY a DESC LIMIT 1,1", 'idx, a'));
        $db->dropTable('abc');
    }


    public function test_rows()
    {
        $db = Database::load();
        $db->dropTable('abc');
        $db->createTable('abc');

        $db->addColumn('abc', 'a', 'varchar');
        $db->addColumn('abc', 'b', 'varchar');
        $db->addColumn('abc', 'c', 'varchar');

        $db->insert('abc', ['a'=>'A', 'b'=>'B', 'c'=>'C']);
        $db->insert('abc', ['a'=>'ABC', 'b'=>'BCD', 'c'=>'CDE']);
        $db->insert('abc', ['a'=>'1', 'b'=>'2', 'c'=>'3']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'banana', 'c'=>'cherry']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'beach', 'c'=>'city']);
        $db->insert('abc', ['a'=>'apple', 'b'=>'box', 'c'=>'cake']);

        $this->assertNotEmpty(count($db->rows('abc')) == 6);
        $this->assertNotEmpty(count($db->rows('abc', "LIMIT 2,2")) == 2 );
        $this->assertNotEmpty(count($db->rows('abc', "a LIKE 'a%' GROUP BY a ORDER BY cnt DESC LIMIT 0,2", 'a,b,c,COUNT(*) as cnt')) == 2 );

        $db->dropTable('abc');
    }

    public function test_result_count() {
        $table = 'test_result';
        $db = Database::load();
        $db->dropTable($table);
        $db->createTable($table);

        $db->addColumn($table, 'a', 'varchar');

        $db->insert($table,['a'=>'b']);

        $this->assertTrue($db->result($table, 'a') == 'b');
        $this->assertTrue($db->count($table) == 1);

        $db->dropTable($table);
    }

}
