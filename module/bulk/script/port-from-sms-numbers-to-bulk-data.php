<?php
use sap\src\Database;




//$old = Database::mysql('localhost', 'test', 'root', '7777');

$db = Database::load();

$i = 0;

while ( $row = $db->row('sms_numbers') ) {
    $i++;
    $idx = 0;

    $idx = $row['idx'];
    if ( empty($row['mobile_number']) ) {
        echo 'e';
    }
    else {
        $row['number'] = adjust_number($row['mobile_number']);
        if ( !empty($row['number']) ) {
            unset($row['mobile_number']);
            unset($row['idx']);
            $sms = entity(BULK_DATA)->load('number', $row['number']);
            if ( $sms ) {
                echo 'U';
                $sms->set($row)->save();
            }
            else {
                echo 'n';
                entity(BULK_DATA)
                    ->set($row)
                    ->save();
            }
        }
        else {
            echo " E($row[mobile_number]) ";
        }
    }
    if ( $idx ) {
        $db->delete('sms_numbers', "idx=$idx");
    }
    usleep(1000);
    if ( ! ( $i % 100 ) ) {
        echo " $i ";
        sleep(1);
    }

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


