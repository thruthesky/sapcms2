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
            ->add('Fruit', 'varchar')
            ->add('Car', 'varchar')
            ->add('Animal', 'varchar');

        entity($table)
            ->set('Fruit', 'Apple')
            ->set('Car', 'BMW')
            ->set('Animal', 'Cat')
            ->save();

        $this->assertTrue(entity($table)->count() == 1);

        $this->assertTrue( entity($table)->load('Fruit', 'Apple')->get('Car') == 'BMW' );

        entity($table)
            ->set(['Fruit'=>'Banana', 'Car'=>'Starex', 'Animal'=>'Dog'])
            ->save();

        $this->assertTrue(entity($table)->load('Fruit', 'Banana')->get('Animal') == 'Dog');

        entity($table)->load('Animal', 'Dog')->delete();

        $this->assertTrue(entity($table)->load('Fruit', 'Banana') == false);

        $this->assertTrue( entity($table)->load('Car', 'BMW')->get('Fruit') == 'Apple' );
        
        Database::load()->dropTable($table);
    }
}

