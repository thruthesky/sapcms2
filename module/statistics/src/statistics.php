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
		$input = request();
		
		if( !empty( $input ) ) $data['input'] = request();
		$data = self::dateRangeComputation();
		
		if( empty( $input['list_type'] ) ) $data['list_type'] = 'created';//default
		else $data['list_type'] = $input['list_type'];
		
        self::adminUserStatisticsTemplate( $data );
    }
	
	public static function post() {
		$input = request();
		
		if( !empty( $input ) ) $data['input'] = request();
		$data = self::dateRangeComputation();
		
		if( empty( $input['list_type'] ) ) $data['list_type'] = 'created';//default
		else $data['list_type'] = $input['list_type'];
		
		if( $data['list_type'] == 'no_view' ) $data['order_query'] = "ORDER BY $data[list_type] DESC";
		else if( $data['list_type'] == 'no_comment' ) $data['order_query'] = "ORDER BY $data[list_type] DESC";
		
		if( !empty( $input['limit'] ) ) $data['limit'] = $input['limit'];
		else $data['limit'] = 10;
		
        self::adminPostStatisticsTemplate( $data );
    }
	
	/*
	*requires date_from and date_to ( both are should be string date format ) yyyy-mm-dd
	*show_by is used to know when to show daily, weekly, and monthly ( default is ALL or '' )
	*
	*list_type is the type of list ( could be used as field name )
	*date_from_stamp starting stamp for each category ( daily, weekly, monthly )
	*date_to_stamp ending stamp for each category ( daily, weekly, monthly )
	*
	*This function generally returns date difference ( see difference index below )
	*@returns ( if successful )
	Array
		(
			[input] => Array
				(
					[list_type] => created
					[date_from] => 2015-02-06
					[date_to] => 2015-09-03
					[show_by] => 
				)

			[date_from] => 2015-02-06
			[date_to] => 2015-09-03
			[show_by] => 
			[difference] => Array
				(
					[day] => 209
					[week] => 30
					[month] => 7
				)

			[date_from_stamp] => Array
				(
					[day] => 1423152000
					[week] => 1422806400
					[month] => 1422720000
				)

			[date_to_stamp] => Array
				(
					[day] => 1441209600
					[week] => 1440950400
					[month] => 1441036800
				)

			[list_type] => created
		)
	*/
	public static function dateRangeComputation(){
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
		}
		
	
		if( !empty( $input['date_to'] ) ){
			$date_to_stamp = strtotime( $input['date_to'] );
			$data['date_to'] = $input['date_to'];
		}
		else{
			$date_to_stamp = strtotime( "today" );
			$data['date_to'] = date( "Y-m-d", $date_to_stamp );			
		}		
		
		if( $date_from_stamp > $date_to_stamp ){
			error(-80101, "[ date_from ] cannot be more than [ date_to ]");
			$data['show_by'] = '';
			$data['error'] = 1;//
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
			$week_diff    = ceil( ( strtotime( "this week", $date_to_stamp ) - strtotime( "this week", $date_from_stamp ) ) /604800 );//became complicated..
			
			$difference = [];			
			$difference['day'] = $date_diff->days;
			$difference['week'] = $week_diff;		
			$difference['month'] = ( $date_diff->y * 12 ) + ( date("m",$date_to_stamp) - date ("m",$date_from_stamp ) );
			
			$data['difference'] = $difference;	
			
			//automatically show ALL if show_by is empty
			if( $data['show_by'] == '' || $data['show_by'] == 'day'  ){
				$data['date_from_stamp']['day'] = $date_from_stamp;
				$data['date_to_stamp']['day'] = $date_to_stamp;
			}
			if( $data['show_by'] == '' || $data['show_by'] == 'week'  ){
				$data['date_from_stamp']['week'] = strtotime( "this week", $date_from_stamp );				
				$data['date_to_stamp']['week'] = strtotime( "this week", $date_to_stamp );	
			}
			
			if( $data['show_by'] == '' || $data['show_by'] == 'month'  ){
				$data['date_from_stamp']['month'] = strtotime( date('Y-m-1',$date_from_stamp) );				
				$data['date_to_stamp']['month'] = strtotime( date('Y-m-1',$date_to_stamp) );
			}
		}	
		
		
		return $data;
	}
	
	private static function adminUserStatisticsTemplate( $data )
    {

       return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.user',
            'data'=>$data,
        ]);
    }
	
	private static function adminPostStatisticsTemplate( $data )
    {
       return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.post',
            'data'=>$data,
        ]);
    }
}