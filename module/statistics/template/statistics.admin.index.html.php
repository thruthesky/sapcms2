<?php
	$total_users = user()->count();
	$total_queue = entity(QUEUE)->count();
	$total_success = entity(SMS_SUCCESS)->count();
	$total_fail = entity(SMS_FAILURE)->count();
?>

<div class='note'>
	Clicking on more should show a much <b>More</b> detailed list:
	<ol>
		<li>Should be able to list by date</li>
		<li>Should be able to search by.... ( what ever possible fields )</li>
		<li>List by count if applicable( like on page accesses )</li>		
	</ol>
</div>
<table data-role="table" id="table-post-list" data-mode="columntoggle" class="ui-responsive table-stroke">
	<thead>
		<tr>
			<th>Title</th>
			<th data-priority="2">Description</th>
			<th data-priority="1">Value</th>		
			<th>Buttons</th>					
		</tr>
	</thead>
	
	<tbody>
		<tr>
			<td>Total Users</td>
			<td>Total Users Description</td>
			<td><?php echo $total_users?></td>
			<td>More</td>
		</tr>
		<tr>
			<td>Total SMSGate Queues</td>
			<td>Total SMSGate Queues Description</td>
			<td><?php echo $total_queue?></td>
			<td>More</td>	
		</tr>
		<tr>
			<td>Total SMSGate Success</td>
			<td>Total SMSGate Success Description</td>
			<td><?php echo $total_success?></td>
			<td>More</td>	
		</tr>
		<tr>
			<td>Total SMSGate Failures</td>
			<td>Total SMSGate Failures Description</td>
			<td><?php echo $total_fail?></td>
			<td>More</td>	
		</tr>
		<tr>
			<td>Total Page Accesses</td>
			<td>Total Page Accesses Description</td>
			<td>Should list all</td>
			<td>More</td>	
		</tr>
	</tbody>
	
</table>