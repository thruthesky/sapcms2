<?php
add_css();
if( !empty( $data['show'] ) ) $show = $data['show'];
else $show =null;

if( !empty( $data['extra'] ) ) $extra = $data['extra'];
else $extra =null;

if( !empty( $data['keyword'] ) ) $keyword = $data['keyword'];
else $keyword = null;
?>
<form class='message-search'>
	Search
	<input type='hidden' name='show' value='<?php echo $show ?>'/>
	<input type='hidden' name='extra' value='<?php echo $extra ?>'/>
	<input type='text' name='keyword' value ='<?php echo $keyword ?>' />
	<input type='submit'>
</form>