<?php
	//<div class="tab-pane active">
	use sap\src\Database;
	$db = Database::load();
	
	$rows = $db->rows('page_number_extract', 'extracted = 0 LIMIT 379, 4');
	foreach ( $rows as $row ) {		
		$data = [];
		
		$data['number'] = get_number( $row );		
		if( !empty( $data['number'] ) ){
			$res = $db->row( 'smsgate_bulk_data', "number = '".$data['number']."'" );
				if( empty( $res ) ){
				$data['origin'] = $row['origin'];
				$data['category'] = $row['keyword'];
				$data['name'] = get_name( $row );
				$data['title'] = get_title( $row );
				$data['location'] = get_location( $row );
				$data['stamp_last_collection'] = time();
				$data['stamp_last_post'] = get_post_date($row);
				
				print_r( $data );
				echo "Success! $row[url]";
			}
			else{
				echo "Number exists: $row[url] skipping...";
			}
		}
		else{
			echo "Missing number - $row[url] - skipping this ad";
		}
		echo "\n";
		
	}
	
	
	function get_number(array & $row) {
    $delimiter = '<div class="tab-pane active">';
    $delimiter2 = '<div class="tab-pane ">';
    $content = $row['content'];
    $arr = explode($delimiter, $content, 2);
	
    if ( isset($arr[1]) ) {
        $arr = explode($delimiter2, $arr[1], 2);
		$markup = str_replace( "&nbsp;", "", $arr[0] );
		$markup = trim( $markup );
		
		//$markup = "639063104270";
		$markup = preg_replace("/\-\+/", '', $markup); // remove all dashes and + signs
		
		preg_match_all( "/(09)([0-9]+){8}[0-9$]|(639)([0-9]+){8}[0-9$]/", $markup, $number );
		
		/*
        $markup = strip_tags($markup);				
        $markup = trim($markup);
		$markup = adjustNumber( $markup );
        return $markup;*/
		if( !empty( $number[0][0] ) ){
			$number = adjustNumber( $number[0][0] );
		}
		else $number = null;
    }
    return $number;
}

function adjustNumber($number){
	$number = preg_replace("/[^0-9]/", '', $number); // remove all characters
	$number = str_replace("639", "09", $number);
	$number = str_replace("630", "0", $number);
	$number = str_replace("63", "0", $number);
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