<?php
	extract( $variables );	
	//just for page title
	$list =	[
			'created'=>'User Registers',
			'updates'=>'User Updates',
			'logins'=>'User Logins',
			'block'=>'How many users will still be BLOCKED on the said date',
			'resign'=>'Resigned Users',
			];
			
	//just text for date_by
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];
?>

<?php include template('statistics.admin.user.menu'); ?>
<?php include template('statistics.admin.form'); ?>

<?php
if( empty( $data['error'] ) ){
?>
	<h1>User Statistics</h1>
	<?php
	?>
		<h2><?php echo $list[$data['list_type']] ?></h2>
		<table data-role="table" id="table-post-list" class="ui-responsive table-stroke">
			<thead>
				<tr>
					<?php				
					foreach( $data['date_from_stamp'] as $k => $v ){
					?>	
						<th><?php echo $text[$k] ?></th>					
					<?php
					}
					?>
				</tr>
			</thead>	
			<tbody>
				<tr>
				<?php				
				foreach( $data['date_from_stamp'] as $k => $v ){
				?>			
					<td>
				<?php
					$curr_date = $v;
					for( $i = 0; $i <= $data['difference'][$k]; $i++ ){
						//echo date( "r", $curr_date )."<br>";
						$start_range_stamp = strtotime( date( "Y/m/d",$curr_date) );	
						$end_range_stamp = strtotime( date( "Y/m/d",$curr_date)." +1 $k" );				
						
						$date = date( "M d", $start_range_stamp );
						$end_date = date( "M d", $end_range_stamp - 1 );
						
						if( $data['list_type'] == 'updates' ){
							$q = "created > $start_range_stamp AND created < $end_range_stamp AND action='updateUser'";
							$user_count = entity(USER_ACTIVITY_TABLE)->count( $q );
						}
						else if( $data['list_type'] == 'logins' ){
							$q = "created > $start_range_stamp AND created < $end_range_stamp AND action='login'";
							$user_count = entity(USER_ACTIVITY_TABLE)->count( $q );
						}
						else if( $data['list_type'] == 'block' ) {
							$q = "$data[list_type] > $start_range_stamp AND $data[list_type] <> 0";
							$user_count = user()->count( $q );
						}
						else{						
							$q = "$data[list_type] > $start_range_stamp AND $data[list_type] < $end_range_stamp";
							$user_count = user()->count( $q );
						}
						
						if( $k == 'day' ) $date_text = $date ." = ".$user_count;
						else $date_text = $date." to ".$end_date." = ".$user_count;
				?>
						<div><?php echo $date_text ?></div>
					
				<?php
						$curr_date = strtotime( date( "Y-m-d",$curr_date )." +1 $k" );									
					}
				?>
					</td>
				<?php
				}
				?>
				</tr>
			</tbody>	
		</table>
<?php
}
?>