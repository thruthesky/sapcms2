<?php
use sap\app\App;

$extra_selected = "";
$inbox_selected = "";
$sent_selected = "";
if( !empty( $data ) ){
	if( $data['extra'] == 'unread' ) $extra_selected = " is-active";
	else if( $data['show'] == 'inbox' ) $inbox_selected = " is-active";
	else if( $data['show'] == 'sent' ) $sent_selected = " is-active";
}
?>
<ul class='message-menu'>
	<li class='link<?php echo $inbox_selected; ?>' route='message' default_url='?'><span>Inbox</span></li>
	<li class='link<?php echo $extra_selected; ?>' route='message' default_url='?extra=unread'><span>Unread</span></li>
	<li class='link<?php echo $sent_selected; ?>' route='message' default_url='?show=sent'><span>Sent Items</span></li>
</ul>