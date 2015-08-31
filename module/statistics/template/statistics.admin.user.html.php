<?php
	extract( $variables );

	if( !empty( $data['input']['date_by'] ) ) $date_by = $data['input']['date_by'];
	else $date_by = "day";
	
	//Limit will be plus/minus
	if( !empty( $data['input']['limit'] ) ) $limit = $data['input']['limit'];
	else $limit = 5;

	//logins daily, weekly, monthly, yearly
	//default is daily
	if( $date_by == 'day' ) $start_date = strtotime( "today" );//start of the week is monday
	else if( $date_by == 'week' ) $start_date = strtotime( "this monday", time() );//start of the week is monday
	else if( $date_by == 'month' ) $start_date = strtotime(date('Y-m-1'));//
	else{
		//error
		$date_by == 'day';//just default it to day for now
	}

	/*
	$show_by = 	[
				''=>'Show by',
				'created'=>'User Created',				
				'domain'=>'Domain',
				'country'=>'Country',
				'province'=>'Province',
				'city'=>'City',
				'last_login_stamp'=>'Last Login',
				'last_login_ip'=>'Last Login IP'
				];	
	*/	
?>

<form>
	Limit <input type='text' name='limit'>
	Sort by 
	<select name='date_by'>
		<option value='day' <? if( $date_by == 'day' ) echo " selected"?>>Day</option>
		<option value='week' <? if( $date_by == 'week' ) echo " selected"?>>Week</option>
		<option value='month' <? if( $date_by == 'month' ) echo " selected"?>>Month</option>
	</select>
	<input type='submit' value="Submit">
</form>

<h2>Order by [ <?php echo $date_by ?> ] - Limit [ +/-<?php echo $limit ?> ] - Listing by [ created ]</h2>
<div><i>This can only be used with timestamps. Like updated, last access</i></div>
<table data-role="table" id="table-post-list" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th>Date</th>
			<th>Value</th>					
		</tr>
	</thead>	
	<tbody>
		<?php for( $i = -($limit); $i<=$limit; $i++ ){ 
		
			$start_range = strtotime( date( "Y/m/d",$start_date)." $i $date_by" );	
			$end_range = strtotime( date( "Y/m/d",$start_date)." ".( $i + 1 )." $date_by" );
			
			$date = date( "M d H:i:s", $start_range );
			$end_date = date( "M d H:i:s", $end_range - 1 );
			$q = "created > $start_range AND created < $end_range";			
			$users = user()->query( $q );
			if( !empty( $users ) ) $user_count = count( $users );
			else $user_count = 0;
			
			if( $start_range == $start_date ) $current = " current";
			else $current = null;
		?>
		<tr class='tr-class<?php echo $current ?>'>
			<td><span class='date'><?php echo $date ?> to <?php echo $end_date ?></span></td>
			<td><span class='count'><?php echo $user_count ?></span></td>
		</tr>
		<?php } ?>
	</tbody>
	
</table>

<?php
	$total_users = user()->count();
	$today = strtotime( "today" );
	$today_end = strtotime( date( "Y/m/d",$today)." 1 day" );
	
	$todays_user_created = user()->query( "created > $today AND created < $today_end" );
	if( !empty( $todays_user_created ) ) $todays_user_created_count = count( $users );
	else $todays_user_created_count = 0;
?>
<h2>Overall Display</h2>
<table data-role="table" id="table-post-list" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th>Title</th>
			<th>Value</th>					
		</tr>
	</thead>	
	<tbody>
		<tr>
			<td><span class='date'>Online</td>
			<td><span class='count'>Needs Last access for this one</span></td>
		</tr>
		<tr>
			<td><span class='date'>Today's created</td>
			<td><span class='count'><?php echo $todays_user_created_count ?></span></td>
		</tr>
		<tr>
			<td><span class='date'>Total Users</td>
			<td><span class='count'><?php echo $total_users ?></span></td>
		</tr>
	</tbody>
</table>