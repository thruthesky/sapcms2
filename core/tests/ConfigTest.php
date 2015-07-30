<?php
include_once "core/etc/phpunit/test.php";
use sap\core\Database;
use sap\core\Entity;
use sap\core\SQL;
use \sap\core\System;
class ConfigTest extends PHPUnit_Framework_TestCase {
    public function __construct() {
        parent::__construct();
    }

    public function test_entity_field_exist() {

        // Entity::storage('user')->field_exists('name');

    }

    public function test_add_column() {


        /*

        Entity::storage('user')
            ->add('test_field', 'int')
            ->index('test_field');

        */

    }
}
