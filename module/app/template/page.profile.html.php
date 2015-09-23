<div class='profile-wrapper'>
	<span class="take-user-primary-photo">Photo Upload</span>
	<div class="user-primary-photo"></div>
	<form name="profileUpdate">
		<input type="hidden" name="session_login" value="<?php echo login('session_id')?>">
		<?php
		$photo = login()->getPrimaryPhoto();
		if ( $photo ) {
			$url = $photo->urlThumbnail(140, 140);
			echo "<img src='$url'>";
		}
		?>
		<?php
		echo html_row([
			'caption' => 'User ID',
			'text' => login('id')
		]);
		echo html_row([
			'caption' => 'Name',
			'text' => html_input([
				'name' => 'name',
				'placeholder' => 'Name',
				'value' => login('name')
			])
		]);
		echo html_row([
			'caption' => 'Email',
			'text' => html_input([
				'name' => 'mail',
				'type' => 'email',
				'placeholder' => 'Email',
				'value' => login('mail')
			])
		]);
		?>
		<input type="submit" value="SUBMIT">
	</form>
</div>