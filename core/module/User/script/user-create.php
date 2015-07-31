<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */
use sap\core\User;
User::create()
    ->set('id', 'jaeho')
    ->set('name', "JaeHo M. Song")
    ->set('email', 'jaeho2@naver.com')
    ->save();
