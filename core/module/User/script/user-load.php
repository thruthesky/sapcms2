<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */
use sap\core\module\User;
$argv = $GLOBALS['argv'];
$user = User::load($argv[2])->getRecord();
print_r($user);
