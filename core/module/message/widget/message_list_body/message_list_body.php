<?php
add_css();
//di( $widget );
$messages = $widget['messages'];
?>
<div class='message-list-body'>
<?php widget( 'message_error_handling', $widget['options'] ); ?>
<div class='send-message'>
	<a href='/message/create'>Send A message</a>
</div>
<?php foreach( $messages as $message ){ 
	if( $widget['show'] == 'inbox' ) $user = User()->load( $message['idx_from'] );
	else if( $widget['show'] == 'sent' ) $user = User()->load( $message['idx_to'] );
	
	$post_primary_photo = null;
	$user_photo = data()->loadBy('user', 'primary_photo', 0, $user->idx);	
	if( !empty( $user_photo ) ) $post_primary_photo = "<img class='header-primary-photo' src='".$user_photo[0]->urlThumbnail(40,40)."'/>";
	
	$date = date('m-d-y',$message['created']);
	
	if( $message['checked'] == 0 ) $class = ' unread';
	else $class = null;
	
	$files = data()->loadBy('message', 0, $message['idx']);
	$total_files = count( $files );
?>
	<div class='row <?php echo $widget['show'] ?><?php echo $class ?>' idx='<?php echo $message['idx'] ?>'>		
		<div class='profile-photo'><?php echo $post_primary_photo ?></div>		
		<div class='name'><?php echo $user->id ?></div>		
		<div class='title'><?php echo $message['title'] ?></div>
		<div class='content show-on-click'>
			<?php echo $message['content'] ?>
			<?php
				if( !empty( $files ) ){
					if( $total_files > 1 ) display_files_thumbnail( $files, 200, 200 );
					else display_files( $files );
				}
			?>
			<div class='reply'><a href='/message/create?send_id=<?php echo $user->id ?>'>Reply</a></div>
			<div class='delete'><a href='/message/delete?idx=<?php echo $message['idx'] ?>'>Delete</a></div>
		</div>
		<div class='date'><?php echo $date ?></div>		
	</div>
	<?php } ?>
</div>