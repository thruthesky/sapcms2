<?php
namespace sap\site;

use sap\src\Entity;

class site extends Entity {
    public function __construct() {
        parent::__construct(SITE_TABLE);
    }
}

