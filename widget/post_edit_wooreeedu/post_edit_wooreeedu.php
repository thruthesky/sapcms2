<?php
	add_css();
	add_javascript();

	$config = post_config()->getCurrent();
	$data = post_data()->getCurrent();

	// update
	if ( $data ) {
		$action = "/post/edit/submit";
		$idx = $data->idx;
		$title = $data->get('title');
		$content = $data->get('content');
		$submit_text = "글 수정";
	}
	// edit
	else {
		$action = "/post/create/submit";
		$idx = 0;
		$title = request('title');
		$content = request('content');
		$submit_text = "글 등록";
	}

?>

<div class='postEdit wooreeedu'>
	<h2><?php echo $config->get('name')?></h2>
	<script src="/core/etc/editor/ckeditor/ckeditor.js"></script>
	<form action="<?php echo $action ?>" class="ajax-file-upload" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo $config->id; ?>">
		<input type="hidden" name="idx" value="<?php echo $idx; ?>">
		<input type="hidden" name="file_display" value="1">
		<input type="hidden" name="content_type" value="H">
		<?php include template('element/hidden.variables'); ?>
		<?php include template('element/title'); ?>		
		<?php include template('element/content'); ?>
		<div class='form-buttons clearfix'>
			<a class='right' href="<?php echo url_go_back();?>">취소</a>
			<input class='right' type="submit" value="<?php echo $submit_text; ?>">			
			<?php widget('post_edit_upload_files', ['form_name'=>'files[]']); ?>			
		</div>
	</form>
</div>
<script>
    
</script>

