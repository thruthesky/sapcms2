<?php
use sap\core\Database;
use sap\core\Entity;

$table = 'sms_extract_numbers';


//$old = Database::mysql('localhost', 'test', 'root', '7777');

$db = Database::load();


$i = 0;

while ( $row = $db->row('sms_numbers') ) {
    if ( $i++ > 30000 ) break;
    $idx = 0;
    if ( empty($row['mobile_number']) ) {
        echo 'e';
    }
    else {
        $row['number'] =adjust_number($row['mobile_number']);
        $idx = $row['idx'];
        if ( !empty($row['number']) ) {
            unset($row['mobile_number']);
            unset($row['idx']);
            $sms = Entity::load($table, 'number', $row['number']);
            if ( $sms ) {
                echo 'U';
                $sms->sets($row)->save();
            }
            else {
                echo 'n';
                Entity::create($table)
                    ->sets($row)
                    ->save();
            }
        }
        else {
            echo " E($row[mobile_number]) ";
        }
    }
    if ( $idx ) $db->delete('sms_numbers', "idx=$idx");
    if ( ! ( $i % 100 ) ) echo " $i ";
}



function adjust_number($number)
{
    $number = preg_replace("/[^0-9]/", '', $number); // remove all characters

    $number = preg_replace("/^639/", "09", $number);
    $number = preg_replace("/^630/", "0", $number);
    $number = preg_replace("/^63/", "0", $number);


    if ( strlen($number) == 10 && $number[0] == '9' ) $number = "0$number";

    // echo "$number\n";

    if ( ! is_numeric($number) ) return false;
    if ( strlen($number) != 11 ) return false;
    if ( $number[2] == '0' && $number[3] == '0' ) return false;
    return $number;
}


/*
$sms = Entity::load($table, 'idx', 5);
$sms->set('changed', time())
    ->save();
*/





/*
stamp_last_sent
count_sent
origin
keyword
mobile_number
count_collection
username
location
title
stamp_last_collection
stamp_last_post
*/
