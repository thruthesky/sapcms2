<?php
add_css();
$comments = post_data()->getComments();
if ( empty($comments) ) return;
?>

<?php foreach ( $comments as $comment ) { ?>
    <div id="comment<?php echo $comment['idx']?>" class="comment" depth="<?php echo $comment['depth']?>">
        <nav class="menu">
            글번호 : <?php echo $comment['idx']?>
        </nav>
        <div class="content">
            <?php echo nl2br($comment['content']); ?>
        </div>
        <section role="files"><?php widget('post_display_files')?></section>
        <form action="/post/edit/submit">
            <input type="hidden" name="idx_parent" value="<?php echo $comment['idx'] ?>">
            <textarea name="content"></textarea>
            <input type="submit" value="ADD COMMENT">
        </form>
    </div>
<?php } ?>
