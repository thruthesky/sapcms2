<div class='register-wrapper'>	
	
	<?php
	$photo = login()->getPrimaryPhoto();
	if ( $photo ) $url = $photo->urlThumbnail(140, 140);
	else if( empty( $url ) ) $url = sysconfig(URL_SITE)."module/app/img/register_logo.png";		
	?>
	<div class='logo user-primary-photo take-user-primary-photo'>
		<img src='<?php echo $url; ?>'>
	</div>
	
	<div class="label">Upload a Photo</div>
	
	<form name="register" class='profileUpdate'>
		<input type="hidden" name="session_login" value="<?php echo login('session_id')?>">		
		<?php
		echo html_row([
			'caption' => 'User ID',
			'text' => login('id'),
			'class' => 'id profile',
		]);
		echo html_row([
			'caption' => 'Name',
			'class' => 'name',
			'text' => html_input([
				'name' => 'name',
				'placeholder' => 'Name',
				'value' => login('name')
			])
		]);
		echo html_row([
			'caption' => 'mobile',
			'class' => 'mobile',
			'text' => html_input([
				'name' => 'mobile',
				'type' => 'text',
				'placeholder' => 'Mobile Number',
				'value' => login('mobile')
			])
		]);
		echo html_row([
			'caption' => 'Email',
			'class' => 'mail',
			'text' => html_input([
				'name' => 'mail',
				'type' => 'email',
				'placeholder' => 'Email',
				'value' => login('mail')
			])
		]);		
		?>
		<input type="submit" value="Update Account">
	</form>
</div>