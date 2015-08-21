<?php
namespace sap\post;


use sap\src\Entity;

class PostData extends Entity {
    public function __construct() {
        parent::__construct(POST_DATA);
    }

    /**
     *
     * If there is no current data, then returns FALSE.
     *
     * @return $this|bool
     */
    public function getCurrent() {
        if ( $idx = request('idx') ) {
            return $this->load($idx);
        }
        else return FALSE;
    }
}
