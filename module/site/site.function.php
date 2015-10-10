<?php


use sap\site\site;

function site($idx = null) {
    if ( $idx ) {
        if ( is_numeric($idx) ) return site()->load($idx);
        else return FALSE;
    }
    return new site();
}


