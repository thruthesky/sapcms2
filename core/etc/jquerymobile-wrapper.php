<?php


function _listview($options) {

    $m = '<ul data-role="listview">';

    foreach( $options as $v ) {
        $m .= "<li>$v</li>";
    }

    $m .= "</ul>";

    return $m;
}