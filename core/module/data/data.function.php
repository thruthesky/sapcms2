<?php

use sap\core\data\Data;

function data($idx=null) {
    if ( $idx ) {
        return data()->load('idx', $idx);
    }
    return new Data();
}

