<?php

use sap\Category\Category;

function category($idx = null) {
    if ( $idx ) {
        if ( is_numeric($idx) ) return category()->load($idx);
        return category()->load('code', $idx);
    }
    return new Category();
}
