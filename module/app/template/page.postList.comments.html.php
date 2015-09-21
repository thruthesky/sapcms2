<?php
if ( ! isset($post['comments']) ) return;
$comments = &$post['comments'];
foreach ( $comments as $comment ) {
	$idx_user = $comment['idx_user'];
	if( $idx_user == 0 ) $idx_user = 1;	
	
    $depth = $comment['depth'];
	/*
    if ( $depth > 5 )  $indent = ( 3 * 12 ) + ( $depth - 4 ) * 6;
    else  $indent = ( $depth - 1 ) * 12;//$padding = 12;
    //$indent = ( $depth - 1 ) * $padding;
	*/
	$date = date("d M Y",$comment['created']);
	
	$edit_url = url_post_comment_edit($comment['idx']);
    ?>
    <div id="comment<?php echo $comment['idx']?>" class="comment" idx="<?php echo $comment['idx']?>" depth='<?php echo $depth; ?>'>
		<div class='menu'>
			<span class='delete' idx='<?php echo $comment['idx']; ?>'>
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/delete_comment.png'/>
			</span>
		</div>
        <?php
/*<?php widget('post_view_vote', ['post'=>$comment])?>
*/?>

        <div class="content">
            <?php include template('page.postList.comment.content') ?>
        </div>

        <?php
/*
        <?php widget('post_display_files', ['idx'=>$comment['idx']])?>
*/?>
        <?php
        $files = data()->loadBy('post', $comment['idx_config'], $comment['idx']);
        ?>
        <div class="display-files">
            <?php display_files($files); ?>
        </div>


       <nav class='user-command comment-command'>
			<div class="comment-reply-button">
				Reply
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/blue_dot.png'/>
			</div>  
			<nav class="vote" idx="<?php echo $comment['idx']?>">				
				<div class="good">
					<span class='no'><?php if( $comment['no_vote_good'] > 0 ) echo $comment['no_vote_good']; ?></span> 
					Like<?php echo $comment['no_vote_good'] <= 1 ? "" : "s"?>
				</div>
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/blue_dot.png'/>
			</nav>
			<?php if( $idx_user == login('idx') ){ ?>
			<div class="edit">
				<span class='edit is-comment' idx='<?php echo $comment['idx']; ?>'>Edit</span>
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/blue_dot.png'/>
			</div>
			<?php }else{ ?>
				<div class="edit">
					<a href="#">Report</a>
					<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/blue_dot.png'/>
				</div>
			<?php }?>
			<div class="date">
			   <?php echo $date?>
			</div>	
		</nav>
        <div class="comment-form" style="display:none;">
            <?php include template('page.postList.comment-form') ?>
        </div>

    </div>
<?php } ?>
