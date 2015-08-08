<?php
use sap\core\User\User;
function user($field=null, $value=null) {
    if ( $field === null ) return new User();
    else {
        $user = new User();
        return $user->load($field, $value); // @todo check if it returns User class.
    }
}
