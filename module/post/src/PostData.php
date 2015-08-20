<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {
    public function __construct() {
        parent::__construct(POST_DATA);
    }

    public function getCurrent() {

        if ( $idx = request('idx') ) {
            $this->load(post_data($idx)->get('idx_config'));
        }
        return FALSE;
    }
}
