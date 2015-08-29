<?php
add_css();
$comments = post_data()->getComments();
if ( empty($comments) ) return;
?>

<?php foreach ( $comments as $comment ) { ?>
    <div id="comment<?php echo $comment['idx']?>" class="comment" depth="<?php echo $comment['depth']?>">
        <nav class="menu">
            글번호 : <?php echo $comment['idx']?>


            <a href="<?php echo url_post_comment_edit($comment['idx'])?>">수정</a>

            <a href="<?php echo url_post_delete($comment['idx'])?>">삭제</a>

        </nav>
        <div class="content">
            <?php widget('post_view_content', ['post'=>$comment]) ?>
        </div>
        <section role="files"><?php widget('post_display_files')?></section>

        <?php widget('post_view_comment_form', ['post'=>$comment]); ?>

    </div>
<?php } ?>
