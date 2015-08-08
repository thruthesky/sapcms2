<?php
namespace sap;
use sap\src\Entity;
define('MESSAGE_TABLE', 'message');
class Message extends Entity {

    public function __construct() {
        parent::__construct(MESSAGE_TABLE);
    }

    public static function version() {
        return "0.1";
    }

    public static function init() {
        parent::createTable(MESSAGE_TABLE)
            ->add('idx_from', 'INT UNSIGNED DEFAULT 0')
            ->add('idx_to', 'INT')
            ->add('title', 'varchar')
            ->index('idx_from')
            ->index('idx_to');
    }


    public static function load($field=null, $value=null) {
        $message = new Message();
        $message->find(MESSAGE_TABLE, $field, $value);
    }




}
