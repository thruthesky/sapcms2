<?php
// user, post, data

	$total_users = user()->count();
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
			<td>
				<a href="/admin/statistics/user?list_type=registers">Registers</a><br>
				<a href="/admin/statistics/user?list_type=updates">Updates</a><br>
				<a href="/admin/statistics/user?list_type=logins">Logins</a><br>
				<a href="/admin/statistics/user?list_type=blocks">Blocks</a><br>
				<a href="/admin/statistics/user?list_type=resigns">Resigns</a><br>
			</td>
		</tr>
	</tbody>
	
</table>