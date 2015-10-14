<?php
	$photo = $user->getPrimaryPhoto();
	if ( $photo ) $url = $photo->urlThumbnail(140, 140);
	else if( empty( $url ) ) $url = sysconfig(URL_SITE)."module/app/img/register_logo.png";	
	
	//$date = date("y-m-d",$user['created']);
	$total_posts = post_data()->count('idx_user = '.$user->idx);
	$date =  date("M d, Y",$user->created);
	
	//post_data()->count("idx_user=".$user->idx);
?>
<table class='table-user-info' cellpadding=0 cellspacing=0 width='100%'>
	<tr valign='top'>
		<td>
			<div class='primary-photo'>
				<img src='<?php echo $url;?> '/>
			</div>
		</td>
		<td width='99%'>
			<div class='info'>
				<div class='name'><?php echo $user->name; ?></div>
				<div class='id'>(<?php echo $user->id; ?>)</div>
					<div class='info-item'>
						<span class='label'>Posts: </span>
						<span class='value'><?php echo $total_posts; ?></span>
					</div>
					<div class='info-item'>
						<span class='label'>Join Date: </span>
						<span class='value'><?php echo $date; ?></span>
					</div>
			</div>
		</td>
	</tr>
</table>