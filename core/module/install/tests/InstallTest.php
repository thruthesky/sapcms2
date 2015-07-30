<?php
use sap\core\Config;
use sap\core\module\Install\Install;

include_once "core/etc/phpunit/test.php";
class InstallTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }
    public function testInstall()
    {
        if ( Install::check() ) {
            Config::create()
                ->file(Config::getDatabasePath())
                ->data([])
                ->save();
        }
        $this->assertEmpty(Install::check());



    }



}

