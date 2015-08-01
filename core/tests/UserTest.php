<?php
use sap\core\User;
use sap\src\Entity;

include_once "core/etc/phpunit/test.php";

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

        if ( $user = User::load('id', 'test-id-3') ) $user->delete();

        $user = User::create()
            ->set('id', 'test-id-3')
            ->save();
        $this->assertNotEmpty($user);

        $idx = User::load('id', 'test-id-3')
            ->get('idx');
        $this->assertNotEmpty($idx);

        $re = User::load('id', 'test-id-3')
            ->delete();
        $this->assertNull($re);

        $re = User::load('id', 'test-id-3');
        $this->assertFalse($re);


    }



}
