<?php
add_css();
$config = post_config()->getCurrent();
$data = post_data()->getCurrent();
?>
<div class='commentEdit wooreeedu'>
	<h2>Editing comment idx [ <?php echo $data->idx ?> ]</h2>
	<form class="ajax-file-upload" action="/post/comment/edit/submit" method="post" enctype="multipart/form-data">
		<input type="hidden" name="idx" value="<?php echo $data->idx; ?>">
		<input type="hidden" name="file_display" value="1">
		<?php include template('element/hidden.variables'); ?>
		<?php widget('post_edit_upload_files', ['form_name'=>'files[]']); ?>
		<?php
		echo html_row([
			'class' => 'content',
			'caption' => 'CONTENT',
			'text' => html_textarea([
				'name' => 'content',
				'placeholder' => 'Input content',
				'value' => $data->get('content'),
			]),
		]);
		?>
		<div class='form-buttons'>
			<input type="submit" value="UPDATE">
		</div>
	</form>
</div>