<?php
include_once "core/etc/phpunit/test.php";
use sap\src\Database;
use sap\src\Entity;
class EntityTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
		parent::__construct();
    }


    public function test_entity()
    {
		$table = "entity_test";

        $entity = new Entity($table);
        $entity->createTable()->add('name', 'varchar', 32);
		$entity->set('name', 'JaeHo')->save();
		$this->assertNotEmpty($entity);
        $this->assertNotEmpty($entity->get('idx'));
		$this->assertTrue($entity->get('idx') > 0);

		$item = entity($table)->load($entity->get('idx'));

		$this->assertNotEmpty($item);
		$this->assertTrue($item->get('name') == 'JaeHo');
        $this->assertTrue(entity($table)->load('name', 'JaeHo')->get('name') == 'JaeHo');

        Database::load()->dropTable($table);
        entity($table)->dropTable();
    }


    public function test_set_sets() {
        $table = 'entity_test_2';
        entity($table)->createTable()
            ->add('a', 'char')
            ->add('b', 'char')
            ->add('c', 'char');

        entity($table)->create()
            ->set('a', 'A')
            ->set('b', 'B')
            ->set('c', 'C')
            ->save();

        $this->assertTrue(entity($table)->count() == 1);

        $this->assertTrue( entity($table)->load('a', 'A')->get('b') == 'B' );

        entity($table)
            ->set(['a'=>1, 'b'=>'2', 'c'=>3])
            ->save();

        $this->assertTrue( entity($table)->load('a', '1')->get('b') == '2' );
        
        Database::load()->dropTable($table);
    }
}

