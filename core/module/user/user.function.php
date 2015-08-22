<?php
use sap\core\user\User;
function user($field=null, $value=null) {
    if ( $field === null ) return new User();
    else {
        $user = new User();
        if ( $value === null ) {
            if ( is_numeric($field) ) return $user->load('idx', $field);
            else return $user->load('id', $field);
        }
        else {
            return $user->load($field, $value);
        }
    }
}
