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

        Entity::init($table)->add('name', 'varchar', 32);
		$entity = Entity::create($table)->set('name', 'JaeHo')->save();
		$this->assertNotEmpty($entity);
        $this->assertNotEmpty($entity->idx);
		$this->assertTrue($entity->idx > 0);

		
		$item = Entity::load($table, $entity->idx);
		$this->assertNotFalse($item);
		$this->assertTrue($item->name == 'JaeHo');


        $this->assertTrue(Entity::load($table, 'name', 'JaeHo')->name == 'JaeHo');

        Database::load()->dropTable($table);
    }


    public function test_set_sets() {
        $table = 'entity_test_2';
        Entity::init($table)
            ->add('a', 'char')
            ->add('b', 'char')
            ->add('c', 'char');

        Entity::create($table)
            ->set('a', 'A')
            ->set('b', 'B')
            ->set('c', 'C')
            ->save();

        $this->assertTrue(Entity::query('entity_test_2')->count() == 1);

        $this->assertTrue( Entity::load($table, 'a', 'A')->b == 'B' );

        Entity::create($table)
            ->set(['a'=>1, 'b'=>'2', 'c'=>3])
            ->save();

        $this->assertTrue( Entity::load($table, 'a', '1')->b == '2' );
        
        Database::load()->dropTable($table);
    }
}

