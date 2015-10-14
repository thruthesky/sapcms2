<?php
$messages = $data['messages'];
if( !empty( $messages ) ){
?>

<?php //widget( 'message_error_handling', $data['options'] ); ?>
<?php foreach( $messages as $message ){ 
	if( $data['show'] == 'inbox' ) $user = User()->load( $message['idx_from'] );
	else if( $data['show'] == 'sent' ) $user = User()->load( $message['idx_to'] );

	$post_primary_photo = null;
	$user_photo = data()->loadBy('user', 'primary_photo', 0, $user->idx);
	
	if( !empty( $user_photo ) ) $url = $user_photo[0]->urlThumbnail(40,40);
	else $url = sysconfig(URL_SITE)."module/app/img/no_primary_photo.png";
	
	$post_primary_photo = "<img class='primary-photo' src='".$url."'/>";	

	
	$date = date('m-d-y',$message['created']);
	
	if( $message['checked'] == 0 ) $class = ' unread';
	else $class = null;
	
	$files = data()->loadBy('message', 0, $message['idx']);
	$total_files = count( $files );
	
	$cut_content = substr( $message['content'], 0, 30 )."...";
?>
	<div class='row <?php echo $data['show'] ?><?php echo $class ?>' idx='<?php echo $message['idx'] ?>'>
		<table class='info-table' cellpadding=0 cellspacing=0 width='100%'>
			<tr>
				<td>
					<div class='checkbox-wrapper'>
						<div class='sprite check_box'></div>						
					</div>
				</td>
				<td width='50'>
					<div class='profile-photo'><?php echo $post_primary_photo ?></div>		
				</td>
				<td width='99%'>
					<div class='name'><?php echo $user->id ?></div>
					<div class='title'><?php echo $cut_content ?></div>
					<div class='top-date'><?php echo $date ?></div>
				</td>
				<td class='td-date'>
					<div class='date'><?php echo $date ?></div>
				</td>
			</tr>
		</table>
		<div class='content show-on-click'>
			<?php echo $message['content'] ?>
			<?php
				if( !empty( $files ) ){
					if( $total_files > 1 ) self::display_files_thumbnail( $files, 200, 200 );
					else display_files( $files );
				}
			?>
			<?php			
				if( login('idx') == $message['idx_to'] ){
					$reply = true;
					include template('page.messageCreateForm');
				}
			?>
		</div>	
	</div>
	<?php } ?>
<?php
}
?>