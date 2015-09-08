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
		
		if( $data['list_type'] == 'updates' ){
			$data['extra_query'] = "AND action='updateUser'";
			$table = USER_ACTIVITY_TABLE;
		}
		else if( $data['list_type'] == 'logins' ){
			$data['extra_query'] = "AND action='login'";
			$table = USER_ACTIVITY_TABLE;
		}
		/*
		else if( $data['list_type'] == 'block' ) {
			$q = "$data[list_type] > $start_stamp AND $data[list_type] <> 0";			
			$table = "user";		
		}
		*/
		else{									
			$table = "user";
		}					
		
		if( !empty( $input['group_by'] ) ) $data['group_by'] = $input['group_by'];
		
		$items = self::doQuery( $table, $data );
		$data = array_merge( $items, $data );
	
        self::adminUserStatisticsTemplate( $data );
    }
	
	public static function post() {
		$input = request();
		
		if( !empty( $input ) ) $data['input'] = request();
		$data = self::dateRangeComputation();
		
		if( empty( $input['list_type'] ) ) $data['list_type'] = 'created';//default
		else $data['list_type'] = $input['list_type'];
		
		if( $data['list_type'] == 'comment' ) $data['extra_query'] = " AND idx_parent > 0";
		else if( $data['list_type'] == 'post' ) $data['extra_query'] = " AND idx_parent = 0";
		
		if( !empty( $input['group_by'] ) ) $data['group_by'] = $input['group_by'];	
		
		
		$items = self::doQuery( POST_DATA, $data );		
		$data = array_merge( $items, $data );
		
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
			$date_from_stamp = strtotime( "this week",strtotime( "today" ) );//by default show first day of the week
			$data['date_from'] = date( "Y-m-d", $date_from_stamp );			
		}
		
		if( !empty( $input['date_to'] ) ){
			$date_to_stamp = strtotime( $input['date_to'] );
			$data['date_to'] = $input['date_to'];
		}
		else{
			$date_to_stamp = strtotime( date( "Y-m-d", $date_from_stamp )." +1 week" ) - 1;//by default show last day of the week
			$data['date_to'] = date( "Y-m-d", $date_to_stamp );			
		}		
		
		if( $date_from_stamp > $date_to_stamp ){
			error(-80101, "[ date_from ] cannot be more than [ date_to ]");
			$data['show_by'] = '';
			$data['error'] = 1;//
			$data['date_by'] = [];
		}
		else{
			if( empty( $input['show_by'] ) ) $data['show_by'] = 'day';
			else $data['show_by'] = $input['show_by']; 
		
			$from_diff = date_create( $data['date_from'] );
			$to_diff = date_create( $data['date_to'] );
			$date_diff = date_diff( $from_diff, $to_diff );				
			$week_diff    = ceil( ( strtotime( "this week", $date_to_stamp ) - strtotime( "this week", $date_from_stamp ) ) /604800 );//became complicated..
			
			$difference = [];			
			$difference['day'] = $date_diff->days;
			$difference['week'] = $week_diff;	

			if( date("m",$date_to_stamp) < date ("m",$date_from_stamp ) ) $month_to = date ("m",$date_to_stamp ) + 12;
			else $month_to = date ("m",$date_to_stamp );
			
			$difference['month'] = ( $date_diff->y * 12 ) + ( $month_to - date ("m",$date_from_stamp ) );

			$data['difference'] = $difference;	
			
			//automatically show ALL if show_by is empty
			if( $data['show_by'] == '' || $data['show_by'] == 'day'  ){
				$data['date_from_stamp']['day'] = $date_from_stamp;
				$data['date_to_stamp']['day'] = strtotime( date( "Y-m-d",$date_to_stamp )." +1 day" ) - 1;//needs more test
				$data['sql_group_by'] = " GROUP BY day( FROM_UNIXTIME( created ) )";
				$data['date_guide'] = "Y-m-d";
			}
			/*
			if( $data['show_by'] == '' || $data['show_by'] == 'week'  ){
				$data['date_from_stamp']['week'] = strtotime( "this week", $date_from_stamp );				
				$data['date_to_stamp']['week'] = strtotime( "this week", $date_to_stamp );				
				$data['date_to_stamp']['week'] = strtotime( date( "Y-m-d",strtotime( "this week", $date_to_stamp ) )." +1 week" ) - 1;//needs more test
				$data['sql_group_by'] = " GROUP BY week( FROM_UNIXTIME( created ) )";
				$data['date_guide'] = "W_Y";
			}
			*/
			if( $data['show_by'] == '' || $data['show_by'] == 'month'  ){
				$data['date_from_stamp']['month'] = strtotime( date('Y-m-1',$date_from_stamp) );				
				$data['date_to_stamp']['month'] = strtotime( date('Y-m-1',$date_to_stamp) );
				$data['date_to_stamp']['month'] = strtotime( date( "Y-m-1",$date_to_stamp )." +1 month" ) - 1;//needs more test
				$data['sql_group_by'] = " GROUP BY month( FROM_UNIXTIME( created ) )";
				$data['date_guide'] = "Y-m";
			}
		}	
		
		
		return $data;
	}
	
	public static function doQuery( $table, $data ){
		$data['table'] = $table;
	
		$start_stamp = $data['date_from_stamp'][$data['show_by']];
		$end_stamp = $data['date_to_stamp'][$data['show_by']];
		
		//TEMP SOLUTION ONLY
		if( $data['list_type'] == 'block' ) $q = "block > $start_stamp AND block <> 0";
		else $q = "created > $start_stamp AND created < $end_stamp";	
		
		if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";		
	
		if( empty( $data['group_by'] ) ) {
			$q .= $data['sql_group_by'];
			$select = "created,idx,count(*)";			
			
		}
		else{			
			$q .= $data['sql_group_by'].",$data[group_by]";
			$select = "created,$data[group_by],count(*)";
		}
		$count_per_day = entity($table)->rows( $q, $select );
		/*di( $q );
		di( $select );
		di( $count_per_day );
		exit;*/
		$detailed_items = 0;
		$highest = 0;
		
		if( !empty( $count_per_day ) ){	
			foreach( $count_per_day as $arr ){
				$arr = array_values( $arr );
				$date_index = date( "$data[date_guide]",( $arr[0] ) );
				if( !empty( $items[ $date_index ] ) ) $detailed_items++;
				
				$items[ $date_index ][$arr[1]] = $arr[2];					
				if( $highest < $arr[2] ) $highest = $arr[2];
			}
		}
		
		$max_total_iteration = 1;
		$temp_i = $highest;
		while( $temp_i > 10 ){
			$max_total_iteration *= 10;
			$temp_i = $temp_i/10;										
		}
		
		$data['custom_bar_width'] = 100 / ( $data['difference'][$data['show_by']] + 1 + $detailed_items );//+$detailed_items
		
		$data['max_total'] = ceil( $highest/$max_total_iteration ) * $max_total_iteration;
		if( empty( $data['max_total'] ) || $data['max_total'] < 10 ) $data['max_total'] = 10;		
		
		$data['graph_interation'] = ceil( $data['max_total'] / 20 );		
		
		$overall_statistics = [];
		$date_now = $start_stamp;
		
		for( $i = 0; $i <= $data['difference'][$data['show_by']]; $i ++){
			$date_index = date( "$data[date_guide]",( $date_now ) );									
			
			if( !empty( $items[ $date_index ] ) ){
				$collection = $items[ $date_index ];				
				foreach( $collection as $k => $v ){					
					if( $data['show_by'] == 'month' ) $title = "Month of ".date( "M, Y",$date_now )."<br>";
					else $title = date( "M d, Y",$date_now )."<br>";
				
					$stats = [];										
					
					$stats['title'] = $title;
					$stats['date'] = $date_index;
					$stats['idx'] = $k;
					$stats['count'] = $v;
					$stats['border_code'] = $i;
					$overall_statistics[] = $stats;
				}
			}
			else {
				if( $data['show_by'] == 'month' ) $title = "Month of ".date( "M, Y",$date_now )."<br>";
				else $title = date( "M d, Y",$date_now )."<br>";
			
				$stats = [];
				$stats['title'] = $title;
				$stats['date'] = $date_index;				
				$overall_statistics[] = $stats;
			}
			$date_now = strtotime( date( "Y-m-d",$date_now )." +1 $data[show_by]" );
		}		
		$data['overall_statistics'] = $overall_statistics;		

		return $data;
	}
	
	private static function adminUserStatisticsTemplate( $data )
    {
		$page = 'statistics.admin.graph';
		$data['menu'] = 'user';//temp
		return Response::renderSystemLayout([
			'template'=>'statistics.layout',
			'page'=>$page,
			'data'=>$data,
		]);
    }
	
	private static function adminPostStatisticsTemplate( $data )
    {			
		$page = 'statistics.admin.graph';
		$data['menu'] = 'post';//temp
		return Response::renderSystemLayout([
			'template'=>'statistics.layout',
			'page'=>$page,
			'data'=>$data,
		]);
    }
}