<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */


use sap\core\User\User;


$password = "hmmv";
for( $i=0; $i<1000; $i++ ) {
    $id = "ID$i." . time();
    $user = user()->create($id);
    $user
        ->setPassword($password)
        ->set('name', "Name $i")
        ->set('mail', "mail$i@gmail.com")
        ->save();
}

