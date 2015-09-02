<?php
	extract( $variables );
	
	$list =	[
			'created'=>'User Registers',
			'changed'=>'User Updates',
			'last_login'=>'User Logins',
			'block'=>'Blocked Users',
			'resign'=>'Resigned Users',
			];
			
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];
	
	$today = strtotime( "today" );
	$this_week = date( "Y-m-d", strtotime( "this week") );//to remove H i s
	$this_week = strtotime( $this_week );
	$this_month = strtotime( date('Y-m-1') );
?>
<h1>User Statistics</h1>
<?php
foreach( $list as $field => $value ){
?>
	<h2><?php echo $value?></h2>
	<table data-role="table" id="table-post-list" class="ui-responsive table-stroke">
		<thead>
			<tr>
				<th>Label</th>
				<th>Value</th>					
			</tr>
		</thead>	
		<tbody>
			<?php 						
			$date_by = 	[
						'day'=> $today,
						'week'=> $this_week,
						'month'=> $this_month,
						];									
			
			foreach( $date_by as $k => $v ){
			
				$start_range = strtotime( date( "Y/m/d",$v) );	
				$end_range = strtotime( date( "Y/m/d",$v)." +1 $k" );				
				
				$date = date( "M d", $start_range );
				$end_date = date( "M d", $end_range - 1 );
				$q = "$field > $start_range AND $field < $end_range";			
				$user_count = user()->count( $q );								

				$extra_label = '';
				if( $k != 'day' ) $extra_label = " ( $date - $end_date )";
			?>
			<tr>
				<td><span class='label'><?php echo $text[$k].$extra_label ?></span></td>
				<td><span class='count'><?php echo $user_count ?></span></td>
			</tr>
			<?php } 
			if( $field != 'changed' && $field != 'last_login' ){
				$total_user_count = user()->count( "$field > 0" );
			?>
			<tr>
				<td><span class='label'>Total</span></td>
				<td><span class='count'><?php echo $total_user_count ?></span></td>
			</tr>
			<?php
			}
			?>
		</tbody>	
	</table>
<?php
}
?>