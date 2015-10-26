<?php
/**
 * @input $widget['post'] - is the post or comment.
 */
use sap\core\post\PostVoteHistory;
 
add_css(null, __FILE__);
add_javascript(null, __FILE__);
$post = $widget['post'];
?>
<nav class="vote" idx="<?php echo $post['idx']?>">
    <div class="good">
		<?php if( !empty( $widget['show_icons'] ) ) { 
			
			$PostVoteHistory = new PostVoteHistory;
			
			$voteDone = $PostVoteHistory->voteDone( $post['idx'] );
			if ( empty( $voteDone ) ) $url = "like.png";
			else $url = "like_active.png";
		?>
			<img src="/core/module/post/widget/post_view_wooreeedu_vote/img/<?php echo $url ?>">
		<?php } ?>
        <span class="no"><?php echo $post['no_vote_good'] >= 1 ? $post['no_vote_good'] : "" ?></span> Like<?php echo $post['no_vote_good'] > 1 ? "s":"" ?>
    </div>
</nav>
