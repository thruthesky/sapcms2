<?php include "statistics.default.form.html.php" ?>

<?php
if( empty( $data['error'] ) ){
?>
	<h1>User Statistics</h1>
	<?php
	?>
		<h2>User Registers</h2>
		<table data-role="table" id="table-post-list" class="ui-responsive table-stroke">
			<thead>
				<tr>
					<?php				
					foreach( $date_by as $k => $v ){
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
				foreach( $date_by as $k => $v ){
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
						$q = "block > $start_range_stamp AND block < $end_range_stamp";			
						$user_count = user()->count( $q );
				?>
						<div><?php echo $date." to ".$end_date." : ".$user_count?></div>
					
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