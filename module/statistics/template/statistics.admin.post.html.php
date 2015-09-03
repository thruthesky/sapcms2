<?php
	extract( $variables );	
		
	//just for page title
	$list =	[
			'idx_root'=>'Most Comments',
			'idx_user'=>'Most User Posts ( comments not counted )',
			'idx_config'=>'Most Config Posts ( comments not counted )',
			];
			
	//just text for date_by
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];
?>

<?php include template('statistics.admin.post.menu'); ?>
<?php include template('statistics.admin.form'); ?>

<?php
if( empty( $data['error'] ) ){
?>
	<h1>User Statistics</h1>
	<?php
	?>
		<h2>
			<?php
				//just for title...
				echo $list[$data['list_type']];
				if( !empty($data['group_by'])  ) echo " grouped by ".$data['group_by'];
			?>
		</h2>
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
				if( empty( $data['group_by'] ) ) $group_by = $data['list_type'];
				else $group_by = $data['group_by'];
				
				foreach( $data['date_from_stamp'] as $k => $v ){
				?>			
					<td>
				<?php
					$curr_date = $v;
					for( $i = 0; $i <= $data['difference'][$k]; $i++ ){
						$start_range_stamp = strtotime( date( "Y/m/d",$curr_date) );	
						$end_range_stamp = strtotime( date( "Y/m/d",$curr_date)." +1 $k" );				
						
						$date = date( "M d", $start_range_stamp );
						$end_date = date( "M d", $end_range_stamp - 1 );
						
						$q = "created > $start_range_stamp AND created < $end_range_stamp";				
						if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";						
						$all_posts = entity(POST_DATA)->count( $q );
						
						$q .= " GROUP BY $group_by";
						$q .= " ORDER BY c DESC";							
						$posts = entity(POST_DATA)->rows( $q, "$group_by,count(*) as c" );
						
						if( $k == 'day' ) $date_text = $date ." ( ".$all_posts." )";
						else $date_text = $date." to ".$end_date." ( ".$all_posts." )";
				?>				
				<div><?php echo $date_text?></div>
				<ol>
				<?php
					foreach( $posts as $p ){					
				?>
					<li><?php echo $group_by ?> [ <?php echo $p[ $group_by ]?> ] - Count [ <?php echo $p[ 'c' ]?> ] </li>
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