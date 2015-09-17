<?php
/**
 * @input $widget['post'] - is the post or comment.
 */
add_css(null, __FILE__);
add_javascript(null, __FILE__);
$post = $widget['post'];
/*
    <div class="bad">
        BAD (<span class="no">$post['no_vote_bad']</span>)
    </div>
*/	
?>

<nav class="vote" idx="<?php echo $post['idx']?>">		
	<div class="good">
		<?php if( $post['no_vote_good'] > 0 ) echo $post['no_vote_good']; ?>
		Like<?php echo $post['no_vote_good'] == 1 ? "" : "s"?>
	</div>
</nav>