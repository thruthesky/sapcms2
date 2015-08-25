<?php
namespace sap\post;


use sap\src\Entity;

class PostConfig extends Entity {
    public function __construct() {
        parent::__construct(POST_CONFIG);
    }


    /**
     *
     *
     * Returns a Post Configuration Entity
     *
     *      - Firstly, it looks for request('id')
     *      - Secondly, it looks for request('idx')
     *      - Lastly, it looks for request('idx_parent')
     *
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
        else if ( $idx = request('idx_parent') ) {
            $post = post_data($idx);
            if ( $post ) {
                if ( $post->get('idx_config') ) return $this->load($post->get('idx_config'));
            }
        }
        return FALSE;
    }

}
