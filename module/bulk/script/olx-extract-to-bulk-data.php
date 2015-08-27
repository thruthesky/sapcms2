<?php
	//olx.ph compatible ONLY

	/*
	*$fail_reason
	*N = Number Exists already on the table
	*M = Missing or incorrect number format
	*/

	//<div class="tab-pane active">
	date_default_timezone_set( "Asia/Manila" );
	$db = new PDO('mysql:host=sap.withcenter.com;dbname=sapcms2', "sapcms2", "Wcinc0453224133~h8");
	//$db = new PDO('mysql:host=localhost;dbname=sapcms2', "root", "1111");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$success_count = 0;
	$fail_count = 0;	
	$q = "SELECT * FROM page_number_extract WHERE origin='olx.ph' AND extracted=0 LIMIT 1";
	$res = $db->query($q);
	$row = $res->fetch(\PDO::FETCH_ASSOC);	

	while ( $row ) {			
		$number = get_number( $row );
		$stamp_last_collection = time();
		$fail_reason = null;
		if( !empty( $number ) ){
			$res = $db->query("SELECT * FROM smsgate_bulk_data WHERE number='$number'");
			$sms = $res->fetch(PDO::FETCH_ASSOC);
			if( empty( $sms ) ){
				$origin = $row['origin'];
				$category = $row['keyword'];
				$username = get_name( $row );				
				$title = get_title( $row );
				$location = get_location( $row );				
				$stamp_last_post = get_post_date($row);
				//print_r( $data );		

				$q = "
				  INSERT INTO smsgate_bulk_data (created, changed, origin, `category`, number, count_collection, username, location, `title`, stamp_last_collection, stamp_last_post)
					VALUES ( $stamp_last_collection, $stamp_last_collection, '$origin', '$category', '$number', 1, '$username', '$location', '$title', $stamp_last_collection, $stamp_last_post)
				  ";
				$db->query($q);				
				echo "Success! $number : $origin : $row[url]\n";
				$success_count++;					
			}
			else{				
				$fail_reason = 'N';//number exists
				$count_collection = $sms['count_collection'] + 1;
				$q = "UPDATE smsgate_bulk_data SET count_collection=$count_collection WHERE idx=$sms[idx]";
				$db->query( $q );
			}			
		}
		else{
			$fail_reason = 'M';//number missing
			$fail_count ++;
		}
		
		if( !empty( $fail_reason ) ) echo "Fail... [ $fail_reason ] : $number : $row[url]\n";
		
		$q = "UPDATE page_number_extract SET content='', extracted='$stamp_last_collection'";
		if( !empty( $fail_reason ) ) $q .= ", fail_reason='$fail_reason'";
		$q .= " WHERE idx=$row[idx]";
		$db->query( $q );
		
		$q = "SELECT * FROM page_number_extract WHERE origin='olx.ph' AND extracted=0 LIMIT 1";
		$res = $db->query($q);
		$row = $res->fetch(\PDO::FETCH_ASSOC);	
	}
	echo "success = $success_count - fail = $fail_count ++;";


function get_number(array & $row) {
    $delimiter = '<span class="contact-reminder">For faster transaction, inform the seller that you found this at OLX.ph</span>';
    $delimiter2 = '</span>';
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
	$number = preg_replace("/[^0-9;]/", '', $number); // remove all characters
	$ascii = explode( ";", $number );
	$number = "";
	foreach( $ascii as $a ){		
		$number .= chr( $a );		
	}
	
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