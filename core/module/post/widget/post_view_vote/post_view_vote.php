<?php
/**
 * @input $widget['post'] - is the post or comment.
 */
add_css(null, __FILE__);
add_javascript(null, __FILE__);
$post = $widget['post'];
?>
<nav class="vote" idx="<?php echo $post['idx']?>">
    <div class="good">
        GOOD (<span class="no"><?php echo $post['no_vote_good']?></span>)
    </div>
    <div class="bad">
        BAD (<span class="no"><?php echo $post['no_vote_bad']?></span>)
    </div>
</nav>
