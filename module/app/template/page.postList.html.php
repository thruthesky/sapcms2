<?php

?>
<div class="post-list">
<?php foreach ( $posts as $post ) { ?>
    <div class="post">
        <?php echo $post['idx']; ?>
        <div class="title">
            <?php echo $post['title']; ?>
        </div>
        <div class="content">
            <?php echo $post['content']; ?>
        </div>		
		<div class="display-files">
			<?php 			
			$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);
			if( !empty( $files ) ) display_files($files);			
			?>
		</div>
        <div class="comment-form">
            <?php  include template('page.postList.comment-form');?>
        </div>
        <div class="comments">
            <?php 
			if( !empty( $set_fid ) ) unset( $set_fid );//what is set_fid in file.html.php for...?
			include template('page.postList.comments'); ?>
        </div>
    </div>
<?php } ?>
</div>