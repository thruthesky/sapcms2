<?php
namespace sap\post;


use sap\src\Entity;

class PostConfig extends Entity {
    public function __construct() {
        parent::__construct(POST_CONFIG);
    }


    public function getCurrentConfig() {

        if ( $id = request('id') ) {
            return $this->load('id', $id);
        }
        else if ( $idx = request('idx') ) {
            $this->load(post_data($idx)->get('idx_config'));
        }
        return FALSE;
    }

}
