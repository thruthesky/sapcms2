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
			$date_from = $input['date_from'];
		}
		else {
			$date_from_stamp = strtotime( "today" );
			$date_from = date( "Y-m-d", $date_from_stamp );
			$data['input']['date_from'] = $date_from;//fix this default value
		}
		
	
		if( !empty( $input['date_to'] ) ){
			$date_to_stamp = strtotime( $input['date_to'] );
			$date_to = $input['date_to'];
		}
		else{
			$date_to_stamp = strtotime( "today" );
			$date_to = date( "Y-m-d", $date_to_stamp );
			$data['input']['date_to'] = $date_to;//fix this default value
		}		
		
		if( $date_from_stamp > $date_to_stamp ){
			error(-80101, "Date from cannot be more thant date more");
			$data['error'] = 1;//need to do something here
			$data['date_by'] = [];
		}
		else{
			if( empty( $input['show_by'] ) ){
				$show_by = '';
				$data['input']['show_by'] = $show_by;//fix this default value
			}
			else {
				$show_by = $input['show_by']; 
			}
		
			$from_diff = date_create( $date_from );
			$to_diff = date_create( $date_to );
			$date_diff = date_diff( $from_diff, $to_diff );				
			$week_diff    = ceil( ( $date_to_stamp - $date_from_stamp ) /604800 );
			$difference = [];			
			$difference['day'] = $date_diff->days;
			$difference['week'] = $week_diff;		
			$difference['month'] = ( $date_diff->y * 12 ) + ( date("m",$date_to_stamp) - date ("m",$date_from_stamp ) );
			
			$data['difference'] = $difference;	
			
			//automatically show ALL if show_by is empty
			if( $show_by == '' || $show_by == 'day'  ){
				$data['date_from']['day'] = $date_from_stamp;
				$data['date_to']['day'] = $date_to_stamp;
				$data['date_by']['day'] = $data['date_from']['day'];//revise code later...
			}
			if( $show_by == '' || $show_by == 'week'  ){
				$data['date_from']['week'] = strtotime( "this week", $date_from_stamp );				
				$data['date_to']['week'] = strtotime( "this week", $date_to_stamp );
				$data['date_by']['week'] = $data['date_from']['week'];//revise code later...	
			}
			
			if( $show_by == '' || $show_by == 'month'  ){
				$data['date_from']['month'] = strtotime( date('Y-m-1',$date_from_stamp) );				
				$data['date_to']['month'] = strtotime( date('Y-m-1',$date_to_stamp) );
				$data['date_by']['month'] = $data['date_from']['month'];//revise code later...
			}
		}
				
        return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.user',
            'data'=>$data,
        ]);
    }
}