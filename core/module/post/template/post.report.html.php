<?php
	//css in post.component.css
	extract( $variables );
	$user_idx = login('idx');
?>
<div class='postReport'>
	<?php if( !empty( $extra_text ) ) { ?>		
		<div class='postNotice<?php echo " ".$extra_text['type'] ?>'>			
			<?php echo $extra_text['message']; ?>
		</div>
	<?php } ?>
	<div class='label'>Reporting post idx [ <?php echo $post->idx ?> ]<br>Title [ <?php echo $post->title ?> ]</div>
	<form action='/post/reportSubmit'>
		<input type='hidden' name='idx' value='<?php echo $post->idx ?>'/>
		<textarea name='reason'></textarea>
		<div class='buttons'>
			<input type='submit' value='Report'>
		</div>
	</form>
</div>