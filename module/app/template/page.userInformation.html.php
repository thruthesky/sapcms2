<?php
	$photo = $user->getPrimaryPhoto();
	if ( $photo ) $url = $photo->urlThumbnail(140, 140);
	else if( empty( $url ) ) $url = sysconfig(URL_SITE)."module/app/img/register_logo.png";	
	
	//$date = date("y-m-d",$user['created']);
	$date =  date("y-m-d",$user->created);
	
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
				<table class='table-listing' cellpadding=0 cellspacing=0 width='100%'>
					<tr>
						<td>
							<span class='label'>Post: </span>
							<span class='value'>XX</span>
						</td>
						<td>
							<span class='label'>Level: </span>
							<span class='value'>XX</span>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<span class='label'>Join Date: </span>
							<span class='value'>XX</span>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>