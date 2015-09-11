<?php

use sap\Category\Category;

function category($idx = null) {
    if ( $idx ) {
        if ( is_numeric($idx) ) return category()->load($idx);
        else return FALSE;
    }
    return new Category();
}
