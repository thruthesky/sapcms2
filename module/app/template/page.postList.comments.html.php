<?php
if ( ! isset($post['comments']) ) return;
$comments = &$post['comments'];
foreach ( $comments as $comment ) {
    $depth = $comment['depth'];
    if ( $depth > 5 ) $padding = 6;
    else $padding = 12;
    $indent = ( $depth - 1 ) * $padding;
    ?>
    <div id="comment<?php echo $comment['idx']?>" class="comment" idx="<?php echo $comment['idx']?>" style="margin-left:<?php echo $indent; ?>px">
        <nav class="menu">
            글번호 : <?php echo $comment['idx']?>
            <a href="<?php echo url_post_comment_edit($comment['idx'])?>">수정</a>
            <a href="<?php echo url_post_delete($comment['idx'])?>">삭제</a>
        </nav>
        <?/*
        <?php widget('post_view_vote', ['post'=>$comment])?>
*/?>

        <div class="content">
            <?php include template('page.postList.comment.content') ?>
        </div>

        <?/*
        <?php widget('post_display_files', ['idx'=>$comment['idx']])?>
*/?>
        <?php
        $files = data()->loadBy('post', $comment['idx_config'], $comment['idx']);
        ?>
        <div class="display-files">
            <?php display_files($files); ?>
        </div>


        <div class="comment-reply-button">
            [Reply...]
        </div>
        <div class="comment-form" style="display:none;">
            <?php include template('page.postList.comment-form') ?>
        </div>

    </div>
<?php } ?>