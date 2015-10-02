<h1>Send a message</h1>
<form action='/message/send'>
	<input type='hidden' name='idx_from' value='<?php echo login('idx') ?>' />
	ID <input type='text' name='user_id_to'/><br>
	TITLE <input type='text' name='title'><br>
	CONTENT <textarea name='content'></textarea>
	<input type='submit' value='send'>
</form>