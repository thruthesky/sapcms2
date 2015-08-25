<?php
namespace sap\post;


use sap\src\Entity;

class PostConfig extends Entity {
    public function __construct() {
        parent::__construct(POST_CONFIG);
    }


    /**
     * @return $this|bool
     */
    public function getCurrent() {
        if ( $id = request('id') ) {
            return $this->load('id', $id);
        }
        else if ( $idx = request('idx') ) {
            $post = post_data($idx);
            if ( $post ) {
                if ( $post->get('idx_config') ) return $this->load($post->get('idx_config'));
            }
        }
        return FALSE;
    }


}
