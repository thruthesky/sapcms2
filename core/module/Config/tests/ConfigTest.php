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

        /*
         * @todo group test.
        $rows = config()
            ->group('groupA');

        $this->assertTrue(count($rows)==2);

        $config
            ->delete('groupA.apple')
            ->delete('groupA.banana');



        $fruits = [
            'GroupB.apple'=>'Apple',
            'GroupB.banana'=>'Banana',
            'GroupB.cherry'=>'Cherry',
            'GroupC.A' => 'Anaconda',
            'GroupC.C' => 'Cobra',
            'D' => 'DDD',
            'E' => 'ET'
        ];
        Config::load()->set($fruits);
        $this->assertTrue(Config::load()->get('D') == 'DDD');
        $this->assertTrue(Config::load()->get('E') == 'ET');
        $this->assertTrue(Config::load()->get('GroupC.A') == 'Anaconda');
        $row = Config::load()->group('GroupC');
        $this->assertTrue(count($row) == 2);

        foreach ( array_keys($fruits) as $k ) {
            $config->delete($k);
        }
        */
    }
}
