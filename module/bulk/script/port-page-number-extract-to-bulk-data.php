<?php
use sap\src\Database;

$db = Database::load();

$i = 0;

//$cond = 'extracted = 0';
$row = $db->row('page_number_extract', 'extracted = 0');
while ( $row ) {	
    $i++;
    $idx = 0;
	$idx = $row['idx'];
	$data = [];
	
	//$data['idx'] = $row['idx'];
	$data['origin'] = $row['origin'];
    $data['category'] = $row['keyword'];
    $data['number'] = get_number($row);
    $data['username'] = get_name($row);	
    $data['location'] = get_location($row);
	$pc = get_province_city($data['location']);	
	$data['province'] = $pc['province'];
	$data['city'] = $pc['city'];
    $data['title'] = get_title($row);		
    $data['stamp_last_collection'] = time();
    $data['stamp_last_post'] = get_post_date($row);

    //echo '$data[keyword]: $data[origin] : $data[name] -> $data[number] : $location : $data[title]\n';
	//di( $data );exit;
	//echo "\n";
	$row = $db->row('page_number_extract', 'extracted = 0');	
	//if( $i >= 5 ) exit;	
	
	if ( !empty($data['number']) ) {
		$sms = entity(BULK_DATA)->load('number', $data['number']);
		if ( $sms ) {
			echo 'U';
			$sms->set($data)->save();
		}
		else {
			echo 'n';
			entity(BULK_DATA)
				->set($data)
				->save();
			$count = $db->count(BULK_DATA, "province='$pc[province]' AND city='$pc[city]'");
			$db->update(LOCATION, ['count'=>$count], "idx=$pc[idx]");
		}
	}
	else {
		echo " E($row[mobile_number]) ";
	}
    	
    if ( $idx ) {		
        $db->update('page_number_extract', ['content'=>'','extracted'=>time()], "idx=$idx");
		$row = $db->row('page_number_extract', 'extracted = 0');
    }
	
    usleep(1000);
    if ( ! ( $i % 100 ) ) {
        echo " $i ";
        sleep(1);
    }
}











function get_number(array & $row) {
    $delimiter = '<span class="number-real"><i class="spr spr-contact"></i>';
    $delimiter2 = '<style>';
    $content = $row['content'];
    $arr = explode($delimiter, $content, 2);
	
    if ( isset($arr[1]) ) {
        $arr = explode($delimiter2, $arr[1], 2);				
        $markup = preg_replace("/[0-9]{6,6}/", '', $arr[0]);			
        $markup = strip_tags($markup);				
        $markup = trim($markup);
		$markup = adjustNumber( $markup );
        return $markup;
    }
    return null;
}

function adjustNumber($number){
	$number = preg_replace("/[^0-9]/", '', $number); // remove all characters
	$number = str_replace("639", "09", $number);
	$number = str_replace("630", "0", $number);
	$number = str_replace("63", "0", $number);
	return $number;
}

function get_name(array & $row) {
	$name = get_data($row, 'username">', '</a>');
	$name = str_replace( "'", "''", $name );//to escape single quote...
	$name = str_replace( "\\", "", $name );//to escape backslash...
    return $name;
}

function get_location(array & $row) {
    return get_data($row, 'Location:</strong>', '</a>');
}

function get_title(array & $row) {
    $title = get_data($row, '<h1 class="brkword lheight28">', '</h1>');
	$title = str_replace( "'", "''", $title );//to escape single quote...
	$title = str_replace( "\\", "", $title );//to escape backslash...
	return $title;
}

function get_post_date(array & $row) {

    $date = get_data($row, 'Date Posted: </strong>', '</span>');

    $arr = explode('(', $date);
    if ( isset($arr[1]) ) {
        $date = str_replace(')', '', $arr[1]);


        $date = preg_replace("/([0-9][0-9]) ([a-zA-Z]+) ([0-9]+)/", "$2 $1, $3", $date);

        $time = strtotime($date);
        return $time;
    }
    return 0;


}

function get_data(array & $row, $d1, $d2 ) {

    $content = $row['content'];
    $arr = explode($d1, $content, 2);
    if ( isset($arr[1]) ) {
        $arr = explode($d2, $arr[1], 2);
        $markup = strip_tags($arr[0]);
        $markup = trim($markup);
        return $markup;
    }
    return null;
}