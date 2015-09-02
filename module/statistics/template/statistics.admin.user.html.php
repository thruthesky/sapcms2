<?php
	extract( $variables );
	
	//all fields that will be queried
	$list =	[
			'created'=>'User Registers',
			'changed'=>'User Updates',
			'last_login'=>'User Logins',
			'block'=>'Blocked Users',
			'resign'=>'Resigned Users',
			];
	//just text
	$text =	[
			'day'=>'Daily',
			'week'=>'Weekly',
			'month'=>'Monthly',
			];					
	
	$date_by = $data['date_by'];
		
?>

<form>
	From
	<input type='date' name='date_from' value='<?echo $data['date_from']?>'>
	To
	<input type='date' name='date_to' value='<?echo $data['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<option value="">ALL</option>
		<?php foreach( $text as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	<input type='submit' value='submit'>
</form>

<?php
if( !empty( $data['date_by'] ) ){
?>
	<h1>User Statistics</h1>
	<?php
	foreach( $list as $field => $value ){
	?>
		<h2><?php echo $value?></h2>
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
						$q = "$field > $start_range_stamp AND $field < $end_range_stamp";			
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
}
?>