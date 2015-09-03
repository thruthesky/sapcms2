<?php
// user, post, data

	$total_users = user()->count();
	$total_posts = entity(POST_DATA)->count();
?>

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
				<a href="/admin/statistics/user?list_type=created">Registers</a><br>
				<a href="/admin/statistics/user?list_type=updates">Updates</a><br>
				<a href="/admin/statistics/user?list_type=logins">Logins</a><br>
				<a href="/admin/statistics/user?list_type=block">Blocks</a><br>
				<a href="/admin/statistics/user?list_type=resign">Resigns</a><br>
			</td>
		</tr>
		<tr>
			<td>Total Posts</td>
			<td>Total number of posts</td>
			<td><?php echo $total_posts?> ( with comments )</td>
			<td>				
				<!--<a href="/admin/statistics/post?list_type=no_view">Most Views</a><br>-->
				<a href="/admin/statistics/post?list_type=idx_root">Most Comments by root post</a><br>
				<a href="/admin/statistics/post?list_type=idx_root&group_by=idx_user">Most Comments by user</a><br>
				<a href="/admin/statistics/post?list_type=idx_root&group_by=idx_config">Most Comments by idx_config</a><br>
				<a href="/admin/statistics/post?list_type=idx_user">Most User Posts</a><br>
				<a href="/admin/statistics/post?list_type=idx_config">Most Config Posts</a><br>
			</td>
		</tr>
	</tbody>
	
</table>