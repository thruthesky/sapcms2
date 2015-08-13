<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Config\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }


    public function test_config_file() {
        $path = PATH_CONFIG . '/my.config.php';
        $re = Config::file($path)
            ->data(['a'=>'b', 'c'=>'def'])
            ->saveFileConfig();
        $this->assertTrue( $re >= 0 );

        $config = Config::read($path);
        $this->assertNotEmpty($config);

        $this->assertTrue($config['a'] == 'b');
        $this->assertTrue($config['c'] == 'def');

        $re = Config::file($path)->deleteFile();
        $this->assertTrue($re);

        $config = Config::read($path);
        $this->assertFalse($config !== FALSE);

    }


    public function test_config_short() {
        config()->set('a', 'b', 1)->delete();

        $this->assertTrue( config('a') === FALSE );

        config('c', 'Cherry');
        $this->assertTrue( config('c') == 'Cherry' );


        config('d', 'Dove', 4);
        $this->assertTrue( config('d') == 'Dove' );
        $this->assertTrue( config()->getEntity('d')->get('idx_target') == 4);
        config()->getEntity('d')->delete();

    }



    public function test_config_action() {

        $config = new Config();
        $config
            ->set('a', 'A', 1)
            ->set('b', 'B', 2)
            ->set('c', 'Cake', 3);
        $this->assertTrue(config('c') == 'Cake');

        $config->getEntity('a')->delete();
        $config->getEntity('b')->delete();
        $config->getEntity('c')->delete();

        $this->assertFalse(config('c') == 'Cake');



        config()
            ->set('groupA.apple', 'Apple', 1)
            ->set('groupA.banana', 'Banana', 2);

        config()->getEntity('groupA.apple')->delete();
        config()->getEntity('groupA.banana')->delete();

        $fruits = [
            'GroupB.apple'=>'Apple',
            'GroupB.banana'=>'Banana',
            'GroupB.cherry'=>'Cherry',
            'GroupC.A' => 'Anaconda',
            'GroupC.C' => 'Cobra',
            'D' => 'DDD',
            'E' => 'ET'
        ];
        config()->set($fruits);

        $this->assertTrue(config('D') == 'DDD');
        $this->assertTrue(config('E') == 'ET');
        $this->assertTrue(config('GroupC.A') == 'Anaconda');

        foreach ( array_keys($fruits) as $k ) {
            config()->getEntity($k)->delete();
        }


        //$this->assertTrue(config()->get('d') == 'e');
    }

    public function test_config_group() {


        config()->group('category')->group('car')
            ->group('Hundai')
            ->set('G-StareX', 'Grand StareX')
            ->set('Accent', 'Accentry Vol. 3');

        config()->group('category')->group('car')
            ->group('BMW')
            ->set('GM', 'Grand Motor BMW')
            ->set('Nubira', 'GM Nubia');

        $this->assertTrue(count(config()->group('category')->group('car')->gets()) == 4 );
        $this->assertTrue(count(config()->group('category')->group('car')->group('Hundai')->gets()) == 2 );
        $this->assertTrue(config()->group('category')->group('car')->group('Hundai')->value('Accent') == 'Accentry Vol. 3' );


        config()->group('category')->group('phone')->group('samsung')
            ->set('GalaxyS3', 'Galaxy S3')
            ->set('GalaxyNote2', 'Galaxy Note 2')
            ->set('GalaxyNote5', 'Galaxy Note 5');

        config()->group('category')->group('phone')->group('apple')
            ->set('iPhone2', 'iPhone 2')
            ->set('iPhone3', 'iPhone 3')
            ->set('iPhone4', 'iPhone 4')
            ->set('iPhone5', 'iPhone 5')
            ->set('iPhone6', 'iPhone 6');

        $this->assertTrue(config()->group('category')->group('phone')->group('samsung')->value('GalaxyNote5') == 'Galaxy Note 5' );

        $this->assertTrue(count(config()->group('category')->group('phone')->gets()) == 8 );
        $this->assertTrue(count(config()->group('category')->gets()) == 12 );


        config()->group('category')->group('phone')->group_delete();

        config()->group('category')->group_delete();
        $this->assertTrue(count(config()->group('category')->gets()) == 0 );

    }

    public function test_config_group_delete() {
        config()->group('phone')->group('my')->set('samsung', 22);
        config()->group('phone')->group('my')->set('apple', 4);
        $this->assertTrue(count(config()->group('phone')->group('my')->gets()) == 2 );
        $this->assertTrue(config()->getEntity('phone.my.apple')->get('value') == 4);
        $this->assertTrue(config()->group('phone')->group('my')->getEntity('apple')->get('value') == 4);
        config()->group('phone')->group('my')->getEntity('apple')->delete();
        $this->assertTrue(count(config()->group('phone')->group('my')->gets()) == 1 );
    }

    public function test_config_load() {
        config()->set('a', 'b', 3);
        $this->assertTrue(config()->load('code', 'a')->get('value') == 'b');
        $this->assertTrue(config()->load('code', 'a')->get('idx_target') == 3);
        $this->assertTrue(config('a') == 'b');
        $this->assertTrue(config()->getEntity('a')->get('value') == 'b');
        $this->assertTrue(config()->getEntity('a')->get('idx_target') == 3);
    }
}
