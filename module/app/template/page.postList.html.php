<?php
//limit temp
use sap\app\App;

if( !empty( $view_post ) ) $class = ' view';
else $class = null;
?>

<div class="post-list<?php echo $class; ?>">
<?php 
foreach ( $posts as $post ) { 
	if( !empty( $skip_idx ) ){
		if( $skip_idx == $post['idx'] ) continue;
	}
	
	$url_report = '#';
	
	$idx_user = $post['idx_user'];
	if( $idx_user == 0 ) $idx_user = 1;
	$user = user()->load( $idx_user )->fields;
	$id = $user['id'];
	
	if( empty( $user['country'] ) ) $location = "No Location";
	else $location = $user['country'];
	
	$fans = "XX fans";

	$date = date( "M d, Y", $post['created'] );

	$post_primary_photo = data()->loadBy('user', 'primary_photo', 0, $idx_user);
	if( !empty( $post_primary_photo ) ) $post_primary_photo = $post_primary_photo[0]->urlThumbnail(140,140);
	else $post_primary_photo = sysconfig(URL_SITE)."module/app/img/no_primary_photo.png";
	$human_timing = App::humanTiming( $post['created'] )." ago";
		
	$files = data()->loadBy('post', post_data($post['idx'])->config('idx'), $post['idx']);	
	$total_files = count( $files );
	//if ( empty($files) ) $total_files = 0;
?>
    <div class="post">
        <?php //echo $post['idx']; ?>
		<nav class="menu">
			<?php if( $idx_user == login('idx') ){?>
			<span class='edit is-post' idx='<?php echo $post['idx']; ?>'>
				<img src="<?php echo sysconfig(URL_SITE) ?>module/app/img/edit_post.png"/>
			</span>
			<span class="delete" idx="<?php echo $post['idx']; ?>">
				<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/delete_post.png'/>
			</span>
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
		
		<section class="content">
			<?php if ( $post['delete'] ) { ?>
				<div class="deleted">
					This post is deleted.
				</div>
			<?php } else { ?>
				<?php
				if( strlen( $post['content'] ) >= 150 ){
					echo "<span class='text-preview'>".substr( $post['content'], 0, 150 )."</span> <span class='see-more'>...See More</span><div class='all-text'>".$post['content']."</div>";
				}
				else{
					echo $post['content'];
				}
				
				?>
				<div class='content-margin'></div>
				<section role="files">
					<div class="display-files" file_count='<?php echo $total_files; ?>'>
						<?php 
						if( $total_files > 1 ) App::display_files_thumbnail( $files, 200, 200 );
						else display_files($files); 
						?>
					</div>
				</section>
			<?php } ?>
		</section>
		
		<nav class='user-command post-command'>
			<?php if ( ! $post['delete'] ) { ?>
				<nav class="vote" idx="<?php echo $post['idx']?>">
					<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/like.png'/>
					<div class="good">
						<span class='no'><?php if( $post['no_vote_good'] > 0 ) echo $post['no_vote_good']; ?></span> 
						Like<?php echo $post['no_vote_good'] <= 1 ? "" : "s"?>
					</div>
				</nav>
				<div class="do-comment">
					<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/comment.png'/>
					   <span class='no'><?php if( $post['no_comment'] > 0 ) echo $post['no_comment']; ?></span>
					   Comment<?php echo $post['no_comment'] <= 1 ? "" : "s"?>
				</div>
				<div class="do-share">
					<img src='<?php echo sysconfig(URL_SITE) ?>module/app/img/share.png'/>
				   Share
				</div>
			<?php } else {?>
				<div class='deleted'>[ Commands are disabled ]</div>
			<?}?>
		</nav>
		
        <div class="comment-form">
            <?php 
			unset( $comment );
			include template('page.postList.comment-form');?>
        </div>
        <div class="comments">
            <?php include template('page.postList.comments'); ?>
        </div>
    </div>
<?php } ?>
</div>