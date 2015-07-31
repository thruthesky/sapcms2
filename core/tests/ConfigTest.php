<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Config;
use sap\core\Database;
use sap\core\Entity;
use sap\core\SQL;
use \sap\core\System;
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

        $re = Config::file($path)->delete();
        $this->assertTrue($re);

        $config = Config::read($path);
        $this->assertFalse($config);

    }

    public function test_entity_field_exist() {

    }

    public function test_create_load_update_delete() {

        $code = "test-code";
        $value = "This is value of the code - $code";

        if ( $config = Config::load('code', $code) ) $config->delete();

        $config = Config::create()
            ->set('code', $code)
            ->set('value', $value)
            ->save();
        $this->assertTrue($config->get('code') == $code);
        $this->assertTrue($config->get('value') == $value);


        $config
            ->set('value', 1)
            ->save();

        $this->assertTrue($config->value == 1);
        $config->value = 2;
        $config->save();


        $config = Config::load('code', $code);
        $this->assertTrue($config->value == 2);


        $new_config = Config::load('code', $code);
        $this->assertNotTrue($config->get('value') == $value);
        $new_config->delete();

        $new_config = Config::load('code', $code);
        $this->assertNotTrue($new_config);

    }
}
