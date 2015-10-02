<?php
add_css();
$unread_selected = '';
$inbox_selected = '';
$sent_selected = '';
if( !empty( $widget['extra'] ) ){
	if( $widget['extra'] == 'unread' ) $unread_selected = "class='is-active'";
}
else if( !empty( $widget['show'] ) ){
	if( $widget['show'] == 'inbox' ) $inbox_selected = "class='is-active'";
	else if( $widget['show'] == 'sent' ) $sent_selected = "class='is-active'";
}
?>
<ul class='message-menu'>
	<li <?php echo $inbox_selected; ?> ><a href='/message'>Inbox</a></li>
	<li <?php echo $unread_selected; ?>><a href='/message?extra=unread'>Unread</a></li>
	<li <?php echo $sent_selected; ?>><a href='/message?show=sent'>Sent</a></li>
</ul>