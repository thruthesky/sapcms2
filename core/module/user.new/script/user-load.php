<?php
/**
 * sap core\module\User\script\user-load.php 2
 * sap core\module\User\script\user-load.php thruthesky
 */


use sap\core\User\User;

$entity = entity('user')->load('id', 'admin');
$user = user()->load('id', 'admin');

//print_r($entity);
//print_r($user);

if ( $entity == $user ) echo "SAME\n";
else echo "NOT SAME\n";


// 이렇게 하면 load() 를 호출 할 때, User Entity Object 가 리턴된다.
$user = new User();
$user->load('id', 'admin');
// 짧게 아래와 같이 할 수 있다.
$user_short = user()->load('id', 'admin');
// 더 짧게 아래와 같이 할 수 있다.
$user_shorter = user('id', 'admin');
if ( $user_short == $user_shorter ) echo "SAME\n";
else echo "NOT SAME";



