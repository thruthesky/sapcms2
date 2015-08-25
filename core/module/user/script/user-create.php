<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */


use sap\core\User\User;

$id = "This is new id.";
$password = "hmmv";

if ( $user = user('id', $id) ) {
    echo "User ($id) found\n";
    //print_r($user);
    $user->delete();
    //print_r($user);
}


$user = user()->create($id);


if ( $user ) {
    $user
        ->setPassword($password)
        ->set('name', "JaeHo M. Song")
        ->set('mail', 'jaeho2@naver.com')
        ->save();


    if ( $user ) {
        if ( $code = User::checkIDPassword($id, $password) ) echo "OK";
        else echo "ERROR: " . get_error_message($code);
        $user->delete();
    }
    else {
        echo "FAILED ON INSERTING";
    }
}

if ( $error = getError() ) {
    print_r($error);
}
