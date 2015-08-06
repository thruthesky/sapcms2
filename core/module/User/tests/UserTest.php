<?php
use sap\core\User\User;
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

        $this->assertTrue( Entity::query('user')->count() > 0 );

        $user->delete();

    }
    public function test_create_save_delete() {
        $user = Entity::create('user')
            ->set('id', "test-id-2")
            ->save()
            ->delete();
        dog($user->idx);
        $this->assertNull($user->idx);

        $user = User::create("test-id-2")
            ->save()
            ->delete();
        dog($user->idx);
        $this->assertNull($user->idx);


        if ( $user = User::load('id', 'test-id-3') ) $user->delete();

        $user = User::create('test-id-3')
            ->save();
        $this->assertNotEmpty($user);
        $this->assertTrue( is_array($user->get()) );

        $idx = User::load('id', 'test-id-3')
            ->get('idx');
        $this->assertNotEmpty($idx);

        $user = User::load('id', 'test-id-3')
            ->delete();
        $this->assertNull($user->idx);

        $user = User::load('id', 'test-id-3');
        $this->assertEmpty($user);



    }

    public function test_user_password() {
        $id = "TEST ID 937";
        $password = "Test password 937.";
        if ( $user = User::load('id', $id) ) $user->delete();
        $created = User::create($id)
            ->setPassword($password)
            ->save();
        $user = User::load('id', $id);
        $this->assertTrue($created->get('password') == encrypt_password($password));
        $this->assertTrue($user->get('password') == encrypt_password($password));
        $this->assertFalse($user->get('password') == "This is wrong password.");
        $this->assertTrue(User::loginCheck($id, $password));
        $this->assertFalse(User::loginCheck($id, $password.'wrong'));
        $user->delete();
    }

}