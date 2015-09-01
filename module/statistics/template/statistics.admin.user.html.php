<?php
	extract( $variables );
	
	$list =	[
			'created'=>'User Registers',
			'changed'=>'User Updates',
			'block'=>'Blocked Users',
			'resign'=>'Resigned Users',
			];
			
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];
?>
<div>
<?php
foreach( $list as $field => $value ){
?>
	<h1><?php echo $value?></h1>
	<table data-role="table" id="table-post-list" data-mode="columntoggle" class="ui-responsive table-stroke">
		<thead>
			<tr>
				<th>Label</th>
				<th>Value</th>					
			</tr>
		</thead>	
		<tbody>
			<?php 
			
			$this_week = date( "Y-m-d", strtotime( "this week") );
			$this_week = strtotime( $this_week );
			$date_by = 	[
						'day'=>strtotime( "today" ),
						'week'=>$this_week,
						'month'=>strtotime( date('Y-m-1') ),
						];									
			
			foreach( $date_by as $k => $v ){
			
				$start_range = strtotime( date( "Y/m/d",$v) );	
				$end_range = strtotime( date( "Y/m/d",$v)." +1 $k" );				
				
				$date = date( "M d", $start_range );
				$end_date = date( "M d", $end_range - 1 );
				$q = "$field > $start_range AND $field < $end_range";			
				$users = user()->rows( $q );
				if( !empty( $users ) ) $user_count = count( $users );
				else $user_count = 0;
			?>
			<tr>
				<td><span class='label'><?php echo $text[$k] . " ( $date - $end_date ) "?></span></td>
				<td><span class='count'><?php echo $user_count ?></span></td>
			</tr>
			<?php } ?>
			<tr>
				<td><span class='label'>Total</span></td>
				<td><span class='count'>XX</span></td>
			</tr>
		</tbody>	
	</table>
<?php
}
?>