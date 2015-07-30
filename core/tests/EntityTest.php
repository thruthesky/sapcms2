<?php
include_once "core/etc/phpunit/test.php";
use \sap\core\Entity;
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
		$this->assertTrue($entity->idx > 0);
		
		$item = Entity::load($table, $entity->idx);
		$this->assertNotFalse($item);
		$this->assertTrue($item->name == 'JaeHo');
		
		
    }
}
