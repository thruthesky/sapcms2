<?php
namespace sap\message;
use sap\src\Entity;
define('MESSAGE_TABLE', 'message');
class Message extends Entity {

    public function __construct() {
        parent::__construct(MESSAGE_TABLE);
    }

    public static function version() {
        return "0.1";
    }

    public function createTable() {
        parent::createTable()
            ->add('idx_from', 'INT UNSIGNED DEFAULT 0')
            ->add('idx_to', 'INT')
            ->add('title', 'varchar')
            ->add('content', 'TEXT')
            ->index('idx_from')
            ->index('idx_to');
    }

}
