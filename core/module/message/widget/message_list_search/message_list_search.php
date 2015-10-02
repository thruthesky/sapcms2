<?php
add_css();
if( !empty( $widget['show'] ) ) $show = $widget['show'];
else $show =null;

if( !empty( $widget['keyword'] ) ) $keyword = $widget['keyword'];
else $keyword = null;
?>
<form class='message-search'>
	Search
	<input type='hidden' name='show' value='<?php echo $show ?>'/>
	<input type='text' name='keyword' value ='<?php echo $keyword ?>' />
	<input type='submit'>
</form>