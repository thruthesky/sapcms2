<?php
namespace sap\dog;

use sap\src\Entity;
define('LOG_TABLE', 'dog_access');

class Dog extends Entity {

    public function __construct() {
        parent::__construct(LOG_TABLE);
        system_log(__METHOD__);
    }

    public function createTable() {
        parent::createTable()
            ->add('idx_from', 'INT UNSIGNED DEFAULT 0')
            ->add('idx_to', 'INT UNSIGNED DEFAULT 0')
            ->add('module', 'varchar', 32)
            ->add('class', 'varchar', 32)
            ->add('method', 'varchar', 32)
            ->add('ip', 'char', 15)
            ->index('idx_from')
            ->index('idx_to')
            ->index('module,class,method');
    }
}
