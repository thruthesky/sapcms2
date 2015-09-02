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
	
	if( !empty( $data['input']['show_by'] ) ){		
		$date_by =	[
					$data['input']['show_by'] => $data['date_from'][ $data['input']['show_by'] ],
					];
	}else{
		$date_by = 	[
					'day'=> $data['date_from']['day'],
					'week'=> $data['date_from']['week'],
					'month'=> $data['date_from']['month'],
					];	
	}	
?>

<form>
	From
	<input type='date' name='date_from' value='<?echo $data['input']['date_from']?>'>
	To
	<input type='date' name='date_to' value='<?echo $data['input']['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<option value="">ALL</option>
		<?php foreach( $text as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['input']['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	<input type='submit' value='submit'>
</form>

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
			foreach( $date_by as $k => $v ){
			?>
			<tr>
				<td><?php echo $text[$k]?></td>
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
			</tr>
			<?php
			}
			?>
		</tbody>	
	</table>
<?php
}
?>