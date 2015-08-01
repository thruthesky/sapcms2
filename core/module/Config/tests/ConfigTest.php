<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Config;

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
        $this->assertFalse($config);

    }



    public function test_config_action() {

        $config = new Config();
        $config
            ->set('a', 'A', 1)
            ->set('b', 'B', 2)
            ->set('c', 'Cake', 3);



    }
}
