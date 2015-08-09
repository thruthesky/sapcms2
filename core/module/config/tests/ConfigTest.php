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
            ->save();
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
        $this->assertTrue( config('d') == 'Done' );
        $this->assertTrue( config()->getEntity('d')->get('idx_target') == 4);
        config()->getEntity('d')->delete();

    }



    public function test_config_action() {

        $config = new Config();
        $config
            ->set('a', 'A', 1)
            ->set('b', 'B', 2)
            ->set('c', 'Cake', 3);
        $this->assertTrue(config()->get('c') == 'Cake');

        $config
            ->delete('a')
            ->delete('b')
            ->delete('c');

        $this->assertFalse(config()->get('c') == 'Cake');



        config()
            ->set('groupA.apple', 'Apple', 1)
            ->set('groupA.banana', 'Banana', 2);

        config()->delete('groupA.apple');
        config()->delete('groupA.banana');

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

        $this->assertTrue(config()->get('D') == 'DDD');
        $this->assertTrue(config()->get('E') == 'ET');
        $this->assertTrue(config()->get('GroupC.A') == 'Anaconda');

        foreach ( array_keys($fruits) as $k ) {
            config()->delete($k);
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
        $this->assertTrue(config()->group('category')->group('car')->group('Hundai')->get('Accent') == 'Accentry Vol. 3' );


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

        $this->assertTrue(config()->group('category')->group('phone')->group('samsung')->get('GalaxyNote5') == 'Galaxy Note 5' );

        $this->assertTrue(count(config()->group('category')->group('phone')->gets()) == 8 );
        $this->assertTrue(count(config()->group('category')->gets()) == 12 );


        config()->group('category')->delete();
        $this->assertTrue(count(config()->group('category')->gets()) == 0 );

    }
}
