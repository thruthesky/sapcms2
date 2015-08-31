<?php
	$total_queue = entity(QUEUE)->count();
	$total_success = entity(SMS_SUCCESS)->count();
	$total_fail = entity(SMS_FAILURE)->count();
?>
<h1>Overall</h1>
<?php include template('smsgate.menu'); ?>
<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>        
        <th data-priority="1" width='150'>Type</th>
        <th data-priority="2">Count</th>
    </tr>
    </thead>
    <tbody>
		<tr>
			<td>Total Queues</td><td><?php echo $total_queue?></td>
		</tr>
		<tr>
			<td>Total Success</td><td><?php echo $total_success?></td>
		</tr>
		<tr>
			<td>Total Failures</td><td><?php echo $total_fail?></td>
		</tr>
	</tbody>
</table>