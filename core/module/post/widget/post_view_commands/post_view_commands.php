<?php
	add_css();
	add_javascript();
?>
<nav class='user-command post-command'>
	<?php widget('post_view_vote', ['post'=>post_data()->getCurrent()->get()])?>
	<div class="do-comment">
		   Comment
	</div>
	<div class="do-share">
	   Share
	</div>
</nav>