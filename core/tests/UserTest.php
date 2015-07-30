<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Database;
use sap\core\Entity;
use sap\core\SQL;
use \sap\core\System;
class UserTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }


    public function test_user() {
        $id = 'sapcms2-test-id';

        $user = Entity::load('user', 'id', $id);
        if ( $user ) $user->delete();

        $user = Entity::load('user', 'id', $id);
        $this->assertFalse($user);

        $user = Entity::create('user');
        $this->assertNotEmpty($user);

        $user->set('id', $id)
            ->set('name', 'JaeHo Song')
            ->save();
    }
    public function test_create_save_delete() {
        $user = Entity::create('user')
            ->set('id', "test-id-2")
            ->save()
            ->delete();
        $this->assertNull($user);
    }



}
