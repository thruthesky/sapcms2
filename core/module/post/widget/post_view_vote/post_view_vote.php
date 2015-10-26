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
        <span class="no"><?php echo $post['no_vote_good'] >= 1 ? $post['no_vote_good'] : "" ?></span> GOOD <?php echo $post['no_vote_good'] > 1 ? "s":"" ?>
    </div>
    <div class="bad">
        BAD (<span class="no"><?php echo $post['no_vote_bad']?></span>)
    </div>
</nav>
