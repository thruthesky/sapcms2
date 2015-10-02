<h1>Send a message</h1>
<form action='/message/send'>
	<input type='hidden' name='idx_from' value='<?php echo login('idx') ?>' />
	<input type='text' name='user_id_to'/>
	<input type='text' name='title'><br>
	<textarea name='content'></textarea>
	<input type='submit' value='send'>
</form>