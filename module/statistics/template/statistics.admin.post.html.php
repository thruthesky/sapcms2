<?php
	extract( $variables );	
		
	//just for page title
	$list =	[
			'created'=>'Posts Created',
			'no_view'=>'Most Views',
			'no_comment'=>'Most Comments',
			'block'=>'Blocked Users',
			'resign'=>'Resigned Users',
			];
			
	//just text for date_by
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];
?>

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
					
						$q = "created > $start_range_stamp AND created < $end_range_stamp";
						if( !empty( $data['order_query'] ) ) $q .= " $data[order_query]";						
						if( !empty( $data['limit'] ) ) $q .= " LIMIT $data[limit]";
						$posts = entity(POST_DATA)->rows( $q );
						$all_posts = count( $posts );
						
						/*
						$q = "created > $start_range_stamp AND created < $end_range_stamp";
						$q .= " GROUP BY idx_user";//idx_user or idx_config
						$q .= " ORDER BY c DESC";
						$posts = entity(POST_DATA)->rows( $q, "count(*) as c" );//array index will all be "c", must be idx_user or idx_config
						*/
				?>				
				<div><?php echo $date." to ".$end_date." = ".$all_posts?></div>
				<ol>
				<?php
					foreach( $posts as $p ){					
				?>
					<li>IDX [ <?php echo $p['idx']?> ] - <?php echo $data['list_type']?> [ <?php echo $p[ $data['list_type'] ]?> ] </li>
				<?php
					}
				?>
				</ol>				
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