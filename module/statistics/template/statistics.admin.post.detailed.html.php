<?php
	extract( $variables );	
		
	//just for page title
	$list =	[
			'comment'=>'Most Comments',
			'post'=>'Most User Posts ( comments not counted )',
			//'idx_config'=>'Most Config Posts ( comments not counted )',
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
				if( !empty($data['group_by'])  ) echo " grouped by <span class='page_highlight'>".$data['group_by']."</span>";
			?>
		</h2>
		<div class='graph-wrapper'>
			<div class='inner'>
				<?php
				if( empty( $data['group_by'] ) ) $group_by = $data['list_type'];
				else $group_by = $data['group_by'];
				
				
				//getting max_total, graph interation
				$start_stamp = $data['date_from_stamp'][$data['show_by']];
				$end_stamp = $data['date_to_stamp'][$data['show_by']];			

				$q = "created > $start_stamp AND created < $end_stamp";	
				if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";
				$q .= $data['sql_group_by'].",$group_by";
				
				$count_per_day = entity(POST_DATA)->rows( $q, "created,$group_by,count(*)" );	

				//0=day,1=idx_parent,2=count
				$items = [];			
				$highest = 0;	
				if( !empty( $count_per_day ) ){
					foreach( $count_per_day as $arr ){
						$arr = array_values( $arr );
						
						if( $data['date_guide'] == 'week' ) $date_index = "W".date( "W-Y", strtotime( "this week", $arr[0] ) );													
						else $date_index = date( "$data[date_guide]",( $arr[0] ) );
						
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
				
				$custom_bar_width = 100 / ( $data['difference'][$data['show_by']] + 1 );
				
				$max_total = ceil( $highest/$max_total_iteration ) * $max_total_iteration;
				if( empty( $max_total ) || $max_total < 10 ) $max_total = 10;
				
				$graph_interation = ceil( $max_total / 20 );
				//for bar guide
				for( $i2 = 0; $i2<=$max_total;$i2+=$graph_interation ){ ?>
					<div class='num-label' style='bottom:<?php echo ( $i2/$max_total * 100 ) ?>%'>
						<div><?php echo $i2 ?></div>
					</div>
				<?php } ?>
			
				<?php
		
				$date_now = $start_stamp;
				$i = 0;
				while( $i <= $data['difference'][$data['show_by']] ){
					$collection = "";
					//echo date( "M d",$date_now )."<br>";
					if( $data['date_guide'] == 'week' ) $date_index = "W".date( "W-Y", strtotime( "this week", $date_now ) );													
					else $date_index = date( "$data[date_guide]",( $date_now ) );
					
					if( !empty( $items[ $date_index ] ) ){
						$collection = $items[ $date_index ];						
						foreach( $collection as $k => $v ){
							$title = "";
							if( $data['group_by'] == 'idx_config' ){
								$post_config = entity( POST_CONFIG )->load( $k )->fields;
								$title = "Count [ $v ]<br>IDX [ $post_config[idx] ]<br>ID [ $post_config[id] ]<br>Name [ $post_config[name] ]";
							}							
														
							?>
								<div class='bar-wrapper has-value <?php echo $i; ?>' style='width:<?php echo $custom_bar_width; ?>%'>
									<div class='bar' title='<?php echo str_replace( "<br>", " - ", $title ); ?>' style='height:<?php echo ( $v/$max_total ) * 100; ?>%'>
										<div class='inner'></div>
									</div>
									<div class='custom_title'>
										<span class='close'>[x]</span>
										<div class='triangle outer'></div>
										<div class='triangle inner'></div>
										<?php echo date( "M d, Y",$date_now ); ?>
										<div>
											<?php echo $title; ?>
										</div>
									</div>
								</div>
							<?php
							$i++;
						}
					}					
					else{
						?>
							<div class='bar-wrapper <?php echo $i; ?>' style='width:<?php echo $custom_bar_width; ?>%'>
								<div class='bar' title='0'>
									<div class='inner'></div>
								</div>
								<div class='custom_title'>
									<span class='close'>[x]</span>
									<div class='triangle outer'></div>
									<div class='triangle inner'></div>
									<?php echo date( "M d",$date_now )."<br>No Items";?>
								</div>
							</div>
						<?php
						$i++;
					}
				?>			
				
				<?php 
					$date_now = strtotime( date( "Y-m-d",$date_now )." +1 $data[show_by]" );	
				}
									
				?>
				<div style='clear:both'></div>
			</div><!--/inner-->
		</div><!--/graph-wrapper-->
<?php
}
?>