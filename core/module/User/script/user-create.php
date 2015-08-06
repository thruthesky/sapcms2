<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */


use sap\core\User\User;

$id = "This is new id.";
$password = "hmmv";
if ( $user = User::load('id', $id) ) $user->delete();

$user = User::create($id);

if ( $user ) {
    $user
        ->setPassword($password)
        ->set('name', "JaeHo M. Song")
        ->set('mail', 'jaeho2@naver.com')
        ->save();
    if ( $user ) {
        if ( $code = User::loginCheck($id, $password) ) echo "ERROR: " . get_error_message($code);
        else echo "OK";
        $user->delete();
    }
    else {
        echo "FAILED ON INSERTING";
    }
}

if ( $error = get_error() ) {
    print_r($error);
}
