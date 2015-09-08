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

function user_exists($id) {
    if ( empty($id) ) return FALSE;
    return user($id);
}

/**
 *
 * Returns the form value base on HTTP FORM INPUT or on Member information.
 *
 *      (1) it first looks up into HTTP FORM INPUT
 *      (2) then, it looks for member information if logged in
 *      (3) if no value found, it returns $default.
 *
 * @param $name
 * @param null $default
 * @return null
 */
function user_form($name, $default=null) {
    static $_in;
    if ( ! isset($_in) ) {
        $login = login();
        if ( $login ) {
            $user = $login->getFields();
            $user = array_merge($user, request());
        }
        else {
            $user = request();
        }
        $_in = $user;
    }
    if ( isset($_in[$name]) ) return $_in[$name];
    else return $default;
}



/**
 *
 * @param $action
 *
 * @code
 *      user_activity('updateUser');
 * @endcode
 */
function user_activity($action) {
    entity(USER_ACTIVITY_TABLE)
        ->set('idx_user', login('idx'))
        ->set('action', $action)
        ->save();
}