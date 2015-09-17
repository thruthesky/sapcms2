<?php
	add_css();
	add_javascript();
	
	$post = $widget['post'];
	$date = date("d M Y",$post['created']);
	
	$post = $widget['post'];
?>
<nav class='user-command comment-command'>
	<div class="reply-button">
		Reply
	</div>  
	<?php widget('post_view_vote', ['post'=>post_data()->getCurrent()->get()])?>	
	<div class="edit">
		<a href="<?php echo url_post_comment_edit($post['idx'])?>">Edit</a>
	</div>
	<div class="date">
	   <?php echo $date?>
	</div>	
</nav>