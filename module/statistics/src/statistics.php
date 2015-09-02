<?php
namespace sap\statistics;
use sap\src\Response;
use sap\src\Request;

use sap\core\user\User;

class Statistics {


	public static function index() {		
        return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.index',
        ]);
    }
	
	public static function user() {
		$data = [];
		$input = request();
		if( !empty( $input ) ) $data['input'] = request();
		
		//date_from and date_to will automatically be "TODAY" if empty
		if( !empty( $input['date_from'] ) ){
			$date_from_stamp = strtotime( $input['date_from'] );
			$data['date_from'] = $input['date_from'];
		}
		else {
			$date_from_stamp = strtotime( "today" );
			$data['date_from'] = date( "Y-m-d", $date_from_stamp );
			//$data['input']['date_from'] = data['date_from'];//fix this default value
		}
		
	
		if( !empty( $input['date_to'] ) ){
			$date_to_stamp = strtotime( $input['date_to'] );
			$data['date_to'] = $input['date_to'];
		}
		else{
			$date_to_stamp = strtotime( "today" );
			$data['date_to'] = date( "Y-m-d", $date_to_stamp );
			//$data['input']['date_to'] = data['date_to'];//fix this default value
		}		
		
		if( $date_from_stamp > $date_to_stamp ){
			error(-80101, "[ date_from ] cannot be more than [ date_to ]");
			$data['show_by'] = '';
			$data['date_by'] = [];
		}
		else{
			if( empty( $input['show_by'] ) ){
				$data['show_by'] = '';
			}
			else {
				$data['show_by'] = $input['show_by']; 
			}
		
			$from_diff = date_create( $data['date_from'] );
			$to_diff = date_create( $data['date_to'] );
			$date_diff = date_diff( $from_diff, $to_diff );				
			$week_diff    = ceil( ( $date_to_stamp - $date_from_stamp ) /604800 );
			$difference = [];			
			$difference['day'] = $date_diff->days;
			$difference['week'] = $week_diff;		
			$difference['month'] = ( $date_diff->y * 12 ) + ( date("m",$date_to_stamp) - date ("m",$date_from_stamp ) );
			
			$data['difference'] = $difference;	
			
			//automatically show ALL if show_by is empty
			if( $data['show_by'] == '' || $data['show_by'] == 'day'  ){
				$data['date_from_stamp']['day'] = $date_from_stamp;
				$data['date_to_stamp']['day'] = $date_to_stamp;
				$data['date_by']['day'] = $data['date_from_stamp']['day'];//revise code later...
			}
			if( $data['show_by'] == '' || $data['show_by'] == 'week'  ){
				$data['date_from_stamp']['week'] = strtotime( "this week", $date_from_stamp );				
				$data['date_to_stamp']['week'] = strtotime( "this week", $date_to_stamp );
				$data['date_by']['week'] = $data['date_from_stamp']['week'];//revise code later...	
			}
			
			if( $data['show_by'] == '' || $data['show_by'] == 'month'  ){
				$data['date_from_stamp']['month'] = strtotime( date('Y-m-1',$date_from_stamp) );				
				$data['date_to_stamp']['month'] = strtotime( date('Y-m-1',$date_to_stamp) );
				$data['date_by']['month'] = $data['date_from_stamp']['month'];//revise code later...
			}
		}
				
        return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.user',
            'data'=>$data,
        ]);
    }
}