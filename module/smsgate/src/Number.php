<?php
namespace sap\smsgate;
use sap\src\Entity;
define('SMSGATE_TABLE', 'sms_extract_numbers');
class Number extends Entity {

    public function __construct() {
        parent::__construct(SMSGATE_TABLE);
    }

}
