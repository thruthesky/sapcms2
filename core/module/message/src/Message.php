<?php
namespace sap\message;
use sap\src\Entity;
class Message extends Entity {

    public function __construct() {
        parent::__construct(MESSAGE_TABLE);
    }

}
