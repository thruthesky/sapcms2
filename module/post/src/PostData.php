<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {
    public function __construct() {
        parent::__construct(POST_DATA);
    }
}
