<?php
	add_css('member.css');
	$user = login();
	if( empty( $user ) ) $submit_text = "REGISTER";
	else $submit_text = "UPDATE";
?>

<div class='member-form-wrapper register wooreeedu'>
	<div class='title'><?php echo $submit_text; ?></div>
	<form class="member-register-form member-form ajax-file-upload" method="post" enctype="multipart/form-data">
		<input type="hidden" name="file_module" value="user">
        <input type="hidden" name="file_type" value="primary_photo">
        <input type="hidden" name="file_idx_target" value="<?php echo login('idx')?>">
        <input type="hidden" name="file_unique" value="1">
        <input type="hidden" name="file_finish" value="1">
        <input type="hidden" name="file_image_thumbnail_width" value="140">
        <input type="hidden" name="file_image_thumbnail_height" value="140">
        <input type="hidden" name="file_callback" value="callback_user_primary_photo_upload">
	<?php

		if( !empty( $variables['user'] ) ){
			echo "<h1>Admin Edit mode</h1>";
			echo html_hidden(['name'=>'idx', 'value'=>$variables['user']->get('idx')]);		
		}
	?>

	<?php if ( !empty( $user ) ) { ?>

		<?php
		$file_upload_form_name = 'primary_photo';
		$form_upload_single_file = true;
		include template('user.photo');
		
		$name = $user->get('name');
		$mail = $user->get('mail');
		if( !empty( $variables['user'] ) ) $user = $variables['user'];
		
		echo html_row([
			'class' => 'data-set username',
			'caption' => 'User ID',
			'text' => html_input([
				'id' => 'id',
				'name' => 'id',
				'value'=> $user->get('id'),
				'placeholder' => 'User ID',
			]),
		]);
		?>
	<?php } else {

		$name = request('name');
		$mail = request('mail');

		?>

		<?php
			echo html_row([
				'class' => 'data-set username',
				'caption' => 'User ID',
				'text' => html_input([
					'id' => 'id',
					'name' => 'id',
					'value'=>request('id'),
					'placeholder' => 'User ID',
				]),
			]);
		?>
		<?php 		
			echo html_row([
				'class' => 'data-set password',
				'caption' => 'Password',
				'text' => html_password([
					'name' => 'password',
					'placeholder' => 'Password',
				]),
			]);
		?>
	<?php } ?>

	<?php
		if( !empty( $variables['user'] ) ){
			$user = $variables['user'] ;
			$name = $user->get('name');
			$mail = $user->get('mail');		
		}
	?>

	<?php 
		echo html_row([
			'class' => 'data-set full_name',
			'caption' => 'Name',
			'text' => html_input([
				'id' => 'name',
				'name' => 'name',
				'value'=>$name,
				'placeholder' => 'Name',
			]),
		]);
	/*echo html_row([
		'caption' => 'Name',
		'text' => html_input(['type'=>'text', 'name'=>'name', 'value'=>$name, 'placeholder'=>'Input Name']),
	]);*/
	?>
	<?php 
		echo html_row([
			'class' => 'data-set email',
			'caption' => 'Email',
			'text' => html_input([
				'id' => 'data-set email',
				'name' => 'mail',
				'value'=>$name,
				'placeholder' => 'Email',
			]),
		]);
	/*echo html_row([
		'caption' => 'Email',
		'text' => html_input(['type'=>'email', 'name'=>'mail', 'value'=>$mail, 'placeholder'=>'Input Email']),
	]);*/
	?>		
		<div class='buttons'>
			<input type="submit" value="<?php echo $submit_text ?>">
			<a href="/" class="ui-btn ui-icon-action">CANCEL</a>
		</div>
	</form>
</div>