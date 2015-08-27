<?php
	//ebay.ph compatible only
	
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
	//$rows = $db->rows('page_number_extract', "extracted = 0 AND keyword = 'Real Estate' LIMIT 0, 400");
	
	//$q = "SELECT * FROM page_number_extract WHERE origin='ebay.ph' LIMIT 1";	
	//http://www.ebay.ph/itm/Rent-To-Own-Condo-Units-in-Mandaluyong-City-No-DP-/291538751047?hash=item43e1104e47
	//http://www.ebay.ph/itm/Spacious-1-BR-Cubao-Condo-for-Rent-/262012556390?hash=item3d012a5466
	//$rows = $db->rows('page_number_extract', "extracted = 0 AND url ='http://www.ebay.ph/itm/apartment-for-rent-in-san-roque-/271949436529?hash=item3f51731671' LIMIT 1");
	
	$q = "SELECT * FROM page_number_extract WHERE origin='ebay.ph' AND extracted=0 AND content <> '' LIMIT 1";
	$res = $db->query($q);
	$row = $res->fetch(\PDO::FETCH_ASSOC);	
	while ( $row  ) {			
		$number = get_number( $row );
		$fail_reason = null;
		$stamp_last_collection = time();
		if( !empty( $number ) ){
			$res = $db->query("SELECT * FROM smsgate_bulk_data WHERE number='$number'");
			$sms = $res->fetch(PDO::FETCH_ASSOC);
				if( empty( $sms ) ){
				$origin = $row['origin'];
				$category = $row['keyword'];
				$username = get_name( $row );
				$title = get_title( $row );
				$location = get_location( $row );				
				$stamp_last_post = 0;//get_post_date($row);
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
		
		$q = "SELECT * FROM page_number_extract WHERE origin='ebay.ph' AND extracted=0 LIMIT 1";
		$res = $db->query($q);
		$row = $res->fetch(\PDO::FETCH_ASSOC);
	}
	echo "success = $success_count - fail = $fail_count ++;";
	
	function get_number(array & $row) {
		$number = null;
		$content = $row['content'];
		//for ebay real estate...
		if( strpos( $row['content'], 'Contact the seller:</div>' ) !== false ){
			$delimiter = 'Contact the seller:</div>';
			$delimiter2 = 'Email the seller';
			
			$arr = explode($delimiter, $content, 2);
			
			if ( isset($arr[1]) ) {
				$arr = explode($delimiter2, $arr[1], 2);
				//$markup = str_replace( "&nbsp;", "", $arr[0] );
				
				$markup = trim( $arr[0] );			
				
				$exploded = explode( "</div>", $markup );								
				foreach( $exploded as $e ){
					$markup = strip_tags( $e );
					$markup = preg_replace("/[^0-9]/", '', $markup); // remove all except numbers
					if( !empty( $markup ) ){
						$number = adjustNumber( $markup );
						if( empty( $number ) ) $number = null;
						else break;
					}
				}
			}	
	}
	//for content number search
	
	if( empty( $number ) ){
		$delimiter = '<div class="tab-pane active">';
		$delimiter2 = '<div class="tab-pane ">';
		
		$arr = explode($delimiter, $content, 2);
		
		if ( isset($arr[1]) ) {
			$arr = explode($delimiter2, $arr[1], 2);
			$markup = str_replace( "&nbsp;", "", $arr[0] );
			$markup = trim( $markup );
			
			//$markup = "09 06 01 04 2 7 0 8129213213123123212390218";
			$markup = preg_replace("/\(|\)|\-|\+|\s|\s+/", '', $markup); // remove all "-", "+", "(", ")", spaces
			//$markup = preg_replace("/\(|\)|\-|\+/", '', $markup); // remove all "-", "+", "(", ")", spaces
			//^ special characters already removed here
			//considering starting of 9, 09, and 639
			
			//preg_match_all( "/(9)([0-9]+){7,7}[0-9$]|(09)([0-9]+){8}[0-9$]|(639)([0-9]+){8}[0-9$]/", $markup, $number );
			preg_match_all( "/(9)([0-9]){9}|(09)([0-9]){9}|(639)([0-9]){9}/", $markup, $number );
			if( empty( $number[0] ) ){
				$number = null;
			}
			else{
				foreach( $number[0] as $n ){				
					$number = adjustNumber( $n );
					if( $number != false ) break;				
				}
			}
		}		
	}
	
	//echo $number." - $row[url]\n";
	
    return $number;
}

function adjustNumber($number){
	$number = preg_replace("/[^0-9]/", '', $number); // remove all characters
	$number = preg_replace("/^639/", "09", $number);
	$number = preg_replace("/^630/", "0", $number);
	$number = preg_replace("/^63/", "0", $number);
	
	// make the 10 digit number into 11 digit.
	if ( strlen($number) == 10 && $number[0] == '9' ) $number = "0$number";
	
	if ( ! is_numeric($number) ) return false;
	if ( strlen($number) != 11 ) return false;
	if ( $number[0] != '0' ) return false;
	if ( $number[1] != '9' ) return false;
	if ( $number[2] == '0' && $number[3] == '0' ) return false;
	
	return $number;
}

function get_name(array & $row) {
	$name = get_data($row, '<span class="mbg-nw">', '</span>');
	$name = str_replace( "'", "''", $name );//to escape single quote...
	$name = str_replace( "\\", "", $name );//to escape backslash...
    return $name;
}

function get_title(array & $row) {
	$title = get_data($row, 'Details about  &nbsp;', '</h1>');
	$title = str_replace( "'", "''", $title );//to escape single quote...
	$title = str_replace( "\\", "", $title );//to escape backslash...
    return $title;
}

function get_location(array & $row) {
	$location = get_data($row, '<div class="iti-eu-bld-gry ">', '</div>');
    return $location;
}

/*
//made a mistake, this is the bidding duration
function get_post_date(array & $row) {
	if( strpos( $row['content'], '<span class="vi-tm-left">' ) !== false ){
		$date = get_data($row, '<span class="vi-tm-left">', '</span>');//only gets date ( ignores time )
	}	
	else if( strpos( $row['content'], '<span id="bb_tlft">' ) !== false ){
		$date = get_data($row, '<span id="bb_tlft">', '</span>');//only gets date ( ignores time )
	}
	if( isset( $date ) ){
		$arr = explode('(', $date);
		if ( isset($arr[1]) ) {
			$date = str_replace(')', '', $arr[1]);
			$date = preg_replace("/([0-9][0-9]) ([a-zA-Z]+) ([0-9]+)/", "$2 $1, $3", $date);		
			$time = strtotime($date);
			
			return $time;
		}
	}
	
    return 0;


}
*/
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