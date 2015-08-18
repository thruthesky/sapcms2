<?php
use sap\core\User\User;
use sap\src\Entity;

include_once "core/etc/phpunit/test.php";

class UserTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function test_user_entity_type() {

        $entity = entity('user')->load('id', 'admin');
        $user = user()->load('id', 'admin');

        $this->assertTrue($entity instanceof Entity);
        $this->assertTrue($user instanceof User);
    }



    public function test_user() {
        $id = 'sapcms2-test-id';

        $user = user('id', $id);
        if ( $user ) $user->delete();

        $user = user('id', $id);
        $this->assertFalse($user);


        $user = user()->create('abc');

        $this->assertTrue( $user instanceof User );
        $this->assertTrue( $user instanceof Entity );

        $user = user()->create();
        $this->assertNotEmpty($user);

        $user->set('id', $id)
            ->set('name', 'JaeHo Song')
            ->save();

        $this->assertTrue( user()->count() > 0 );

        $user->delete();

    }
    public function test_create_save_delete() {
        if ( $user = user('id', 'test-id-2') ) $user->delete();
        $user = user()
            ->set('id', "test-id-2")
            ->save()
            ->delete();

        $this->assertNull($user->get('idx'));

        $user = user()->create("test-id-2")
            ->save()
            ->delete();

        $this->assertNull($user->get('idx'));

        if ( $user = user('id', 'test-id-3') ) $user->delete();

        $user = user()->create('test-id-3')
            ->save();
        $this->assertNotEmpty($user);
        $this->assertTrue( is_array($user->get()) );

        $idx = user('id', 'test-id-3')
            ->get('idx');
        $this->assertNotEmpty($idx);

        $user = user('id', 'test-id-3')
            ->delete();
        $this->assertNull($user->idx);

        $user = user('id', 'test-id-3');
        $this->assertEmpty($user);



    }

    public function test_user_password() {
        $id = "TEST ID 937";
        $password = "Test password 937.";
        if ( $user = user('id', $id) ) $user->delete();
        $created = user()->create($id)
            ->setPassword($password)
            ->save();
        $user = user('id', $id);
        $this->assertTrue($created->get('password') == encrypt_password($password));
        $this->assertTrue($user->get('password') == encrypt_password($password));
        $this->assertFalse($user->get('password') == "This is wrong password.");
        $this->assertTrue(User::checkIDPassword($id, $password));
        //$this->assertFalse(User::checkIDPassword($id, $password.'wrong'));
        $user->delete();
    }

}