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
			
?>

<?php include template('statistics.admin.user.menu'); ?>
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
			?>
		</h2>
		<div class='graph-wrapper'>
			<div class='inner'>
				<?php			
				//getting max_total, graph interation
				$start_stamp = $data['date_from_stamp']['day'];
				$end_stamp = $data['date_to_stamp']['day'] + 86399;				

				//$q = "created > $start_stamp AND created < $end_stamp";	
				//if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";
				
				if( $data['list_type'] == 'updates' ){
					$q = "created > $start_stamp AND created < $end_stamp AND action='updateUser'";
					$q .= " GROUP BY day( FROM_UNIXTIME( created ) ), month( FROM_UNIXTIME( created ) ), year( FROM_UNIXTIME( created ) )";//can only be used for days...
					$count_per_day = entity(USER_ACTIVITY_TABLE)->rows( $q, "created,count(*)" );		
				}
				else if( $data['list_type'] == 'logins' ){
					$q = "created > $start_stamp AND created < $end_stamp AND action='login'";
					$q .= " GROUP BY day( FROM_UNIXTIME( created ) ), month( FROM_UNIXTIME( created ) ), year( FROM_UNIXTIME( created ) )";//can only be used for days...
					$count_per_day = entity(USER_ACTIVITY_TABLE)->rows( $q, "created,count(*)" );		
				}
				else if( $data['list_type'] == 'block' ) {
					$q = "$data[list_type] > $start_stamp AND $data[list_type] <> 0";
					$q .= " GROUP BY day( FROM_UNIXTIME( created ) ), month( FROM_UNIXTIME( created ) ), year( FROM_UNIXTIME( created ) )";//can only be used for days...
					$count_per_day = user()->rows( $q, "created,count(*)" );		
				}
				else{						
					$q = "$data[list_type] > $start_stamp AND $data[list_type] < $end_stamp";
					$q .= " GROUP BY day( FROM_UNIXTIME( created ) ), month( FROM_UNIXTIME( created ) ), year( FROM_UNIXTIME( created ) )";//can only be used for days...
					$count_per_day = user()->rows( $q, "created,count(*)" );		
				}									

				$items = [];				
				$highest = 0;		
				
				//0=day,1=count
				if( !empty( $count_per_day ) ){	
					foreach( $count_per_day as $arr ){
						$arr = array_values( $arr );
						 $items[ date( "Y-m-d", $arr[0] ) ] = $arr[1];					
						 if( $highest < $arr[1] ) $highest = $arr[1];
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
				
				if( empty( $max_total ) ) $max_total = 10;
				
				$graph_interation = ceil( $max_total / 20 );
				//for bar guide
				for( $i2 = 0; $i2<=$max_total;$i2+=$graph_interation ){ ?>
					<div class='num-label' style='bottom:<?php echo ( $i2/$max_total * 100 ) ?>%'>
						<div><?php echo $i2 ?></div>
					</div>
				<?php } ?>
			
				<?php
		
				$date_now = $start_stamp;
				for( $i = 0; $i <= $data['difference']['day']; $i++ ){
					//echo date( "M d",$date_now )."<br>";
					if( !empty( $items[ date( "Y-m-d", $date_now ) ] ) ) $count = $items[ date( "Y-m-d", $date_now ) ];
					else $count = 0;
					
					$title = date( "M d, Y",$date_now )." - Total [ $count ] ";
						?>
							<div class='bar-wrapper<?php if( $count > 0 ) echo " has-value"; ?>' style='width:<?php echo $custom_bar_width; ?>%'>
								<div class='bar' title='<?php echo $title; ?>' style='height:<?php echo ( $count/$max_total ) * 100; ?>%'>
									<div class='inner'></div>
								</div>
								<div class='custom_title'>	
									<span class='close'>[x]</span>
									<div class='triangle outer'></div>
									<div class='triangle inner'></div>
									<?php echo $title; ?>
								</div>
							</div>
						<?php
									
				?>			
				
				<?php 
					$date_now = strtotime( date( "Y-m-d",$date_now )." +1 day" );	
				}
									
				?>
				<div style='clear:both'></div>
			</div><!--/inner-->
		</div><!--/graph-wrapper-->
<?php
}
?>