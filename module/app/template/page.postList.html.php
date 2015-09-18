<?php
//limit temp
function display_files_thumbnail( $files, $height, $width, $limit = 0 ) {
	if ( empty($files) ) return null;	
    $tag_imgs = [];
    $tag_files = [];
    //foreach($files as $file) {
	if( $limit == 0 ) $limit = count( $files );	
	for( $i = 0; $i < $limit; $i ++ ){
		$file = $files[$i];		
        $url = $file->urlThumbnail( $width, $height );
        $name = $file->get('name');
        if ( is_image($name) ) {
            $tag_imgs[] = "<div class='image'><img src='$url'></div>";
        }
        else {
            $tag_files[] = "<div class='attachment'><a href='$url'>$name</a></div>";
        }
    }

    echo "<div class='attachments'>";
    array_walk($tag_files, 'display');
    echo "</div>";
    echo "<div class='images clearfix'>";
    array_walk($tag_imgs, 'display');
    echo "</div>";
}
?>

<div class="post-list">
<?php foreach ( $posts as $post ) { 

	$url_edit = url_post_edit($post['idx']);//"#";
	$url_delete = "#";
	$url_report = "#";
	
	$idx_user = $post['idx_user'];
	if( $idx_user == 0 ) $idx_user = 1;
	$user = user()->load( $idx_user )->fields;
	$id = $user['id'];
	
	if( empty( $user['country'] ) ) $location = "No Location";
	else $location = $user['country'];
	
	$fans = "XX fans";

	$date = date( "M d, Y", $post['created'] );

	$post_primary_photo = data()->loadBy('user', 'primary_photo', $idx_user);
	
	if( !empty( $post_primary_photo ) ) $post_primary_photo = $post_primary_photo[0]->urlThumbnail(140,140);
	
	$human_timing = "XX hours ago";
		
	$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);
	$total_files = count( $files );
	//if ( empty($files) ) $total_files = 0;
?>
    <div class="post">
        <?php //echo $post['idx']; ?>
		<nav class="menu">
			<?php if( $idx_user == login('idx') ){?>
			<a class='edit' href="<?php echo $url_edit ?>">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/edit_post.png'/>
			</a>
			<a class='delete' href="<?php echo $url_delete ?>" onclick="return confirmDeletePost('<?php echo "Post IDX [ ".$post['idx']." ]"; ?>')">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/delete_post.png'/>
			</a>
			<?php }else{ ?>
				<a class='report' href="<?php echo $url_report ?>">
					<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/report.png'/>
				</a>
			<?php }?>
		</nav>
		<section class="user-profile">
			<table cellpadding=0 cellspacing=0 width='100%'>
				<tr>
					<td width='60'>
						<?php if( !empty( $post_primary_photo ) ){?>
							<div class='primary-photo'><img src='<?php echo $post_primary_photo; ?>'/></div>
						<?php } else {?>
							<div class='primary-photo temp'></div>
						<?php }?>
					</td>
					<td>
						<div class='info'>
							<div class='name'><?php echo $id; ?></div>
							<div class='date'><?php echo $date; ?> | <?php echo $human_timing; ?></div>
							<div class='location'><?php echo $location; ?> | <?php echo $fans; ?></div>
						</div>
					</td>
				</tr>
			</table>
		</section>        
        <div class="content">
            <?php echo $post['content']; ?>
        </div>	
			
		<section role="files">
			<div class="display-files" file_count='<?php echo $total_files; ?>'>
				<?php 
				if( $total_files > 1 ) display_files_thumbnail( $files, 200, 200 );
				else display_files($files); 
				?>
			</div>
		</section>
		
		<nav class='user-command post-command'>
			<nav class="vote" idx="<?php echo $post['idx']?>">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/like.png'/>
				<div class="good">
					<?php if( $post['no_vote_good'] > 0 ) echo $post['no_vote_good']; ?>
					Like<?php echo $post['no_vote_good'] <= 1 ? "" : "s"?>
				</div>
			</nav>
			<div class="do-comment">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/comment.png'/>
				   Comment
			</div>
			<div class="do-share">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/share.png'/>
			   Share
			</div>
		</nav>
		
        <div class="comment-form">
            <?php  include template('page.postList.comment-form');?>
        </div>
        <div class="comments">
            <?php
			include template('page.postList.comments'); ?>
        </div>
    </div>
<?php } ?>
</div>