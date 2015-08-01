<?php
use sap\core\Database;
use sap\core\Entity;
use sap\core\File;

/**
 * number of files 14,040
 */

$table = 'sms_extract_numbers';

$db = Database::load();

/*
$db->dropTable($table);
if ( ! $db->tableExists($table) ) {
    $db->createTable($table)
        ->add('number', 'varchar')
        ->add('count_sent', 'int')
        ->add('origin', 'varchar', 32)
        ->add('keyword', 'varchar', 128)
        ->add('username', 'varchar', 64)
        ->add('location', 'varchar', 128)
        ->add('title', 'varchar', 512)
        ->add('count_collection', 'int')
        ->add('stamp_last_sent', 'int')
        ->add('stamp_last_collection', 'int')
        ->add('stamp_last_post', 'int')
        ->unique('number')
        ->index('keyword')
        ->index('stamp_last_sent')
        ->index('location');
}
*/

$i=0;
foreach( glob('F:/olx/olx.ph/item/*',GLOB_NOSORT) as $path ) {
    $i++;
    //echo "$path\n";
    $content = File::read($path);
    $number = get_number($content);
    $number = adjust_number($number);

    if ( empty($number) ) {
        echo 'e';
        continue;
    }

    $in = [];
    $in['number'] = $number;
    $in['origin'] = 'olx.ph';
    $in['keyword'] = null;
    $in['username'] = get_name($content);
    $in['location'] = get_location($content);
    $in['title'] = get_title($content);
    $in['stamp_last_collection'] = time();
    $in['stamp_last_post'] = get_post_date($content);

    $idx = $db->result($table, 'idx', "number='$number'");
    if ( empty($idx) ) {
        $new_idx = $db->insert($table, $in);
        echo 'n';
    }
    else {
        $db->update($table, $in, "idx=$idx");
        echo 'U';
    }
    File::delete($path);
    if ( ! ($i % 100) ) echo " $i ";

}





function get_number(&$content) {
    $delimiter = '<span class="number-real"><i class="spr spr-contact"></i>';
    $delimiter2 = '</li>';
    $arr = explode($delimiter, $content, 2);
    if ( isset($arr[1]) ) {
        $arr = explode($delimiter2, $arr[1], 2);
        $markup = preg_replace("/[0-9]{6,6}/", '', $arr[0]);
        $markup = strip_tags($markup);
        $markup = trim($markup);
        return $markup;
    }
    return null;
}




function get_name(&$content) {
    return get_data($content, 'username">', '</a>');
}

function get_location(&$content) {
    return get_data($content, 'Location:</strong>', '</a>');
}

function get_title(&$content) {
    return get_data($content, '<h1 class="brkword lheight28">', '</h1>');
}

function get_post_date(&$content) {
    $date = get_data($content, 'Date Posted: </strong>', '</span>');
    $arr = explode('(', $date);
    if ( isset($arr[1]) ) {
        $date = str_replace(')', '', $arr[1]);

        $date = preg_replace("/([0-9][0-9]) ([a-zA-Z]+) ([0-9]+)/", "$2 $1, $3", $date);

        $time = strtotime($date);
        return $time;
    }
    return 0;
}


function get_data(&$content, $d1, $d2 ) {
    $arr = explode($d1, $content, 2);
    if ( isset($arr[1]) ) {
        $arr = explode($d2, $arr[1], 2);
        $markup = strip_tags($arr[0]);
        $markup = trim($markup);
        return $markup;
    }
    return null;
}

function adjust_number($number)
{
    $number = preg_replace("/[^0-9]/", '', $number); // remove all characters
    $number = str_replace("639", "09", $number);
    $number = str_replace("630", "0", $number);
    $number = str_replace("63", "0", $number);
    if ( ! is_numeric($number) ) return false;
    if ( strlen($number) != 11 ) return false;
    if ( $number[2] == '0' && $number[3] == '0' ) return false;
    return $number;
}