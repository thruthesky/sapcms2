<?php
//needs search
$posts = post_data()->rows("report = 'Y'");

if( empty( $posts ) ){
	?>
	<h2>No reports recorded</h2>
<?php
}
else{
?>
	<table class='table-report-list' cellpadding=0 cellspacing=0 width='100%'>
	<tr>
		<td>IDX</td>
		<td>Title</td>
		<td>Reason</td>
		<td>Created</td>
	</tr>
<?php
	foreach( $posts as $post ){
	?>
		<tr valign='top'>
			<td><?php echo $post['idx'] ?></td>
			<td><div class='nowrap'><?php echo textLengthLimit( $post['title'], 18 ) ?></div></td>
			<td width='99%'><?php echo $post['reason'] ?></td>
			<td><div class='nowrap'><?php echo date( "d-m-y", $post['created'] ) ?></div></td>
		</tr>
	<?php
	}
}
?>
	</table>

<style>
.table-report-list tr td{
	padding:10px 5px;
}

.nowrap{
	white-space:nowrap;
}
</style>