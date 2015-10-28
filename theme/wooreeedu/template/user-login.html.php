<?php
	add_css('member.css');
	widget('error');
?>

<div class='member-form-wrapper login wooreeedu'>
	<div class='title'>Sign in</div>
	<form class='user-login-form member-form' action="/user/login" method="post" data-ajax="false">
		<!--
		<input type="text" name="id" value="">
		<input type="password" name="password" value="">
		-->
		<?php
		echo html_row([
			'class' => 'data-set username',
			'caption' => 'User ID',
			'text' => html_input([
				'id' => 'id',
				'name' => 'id',
				'placeholder' => 'User ID',
			]),
		]);
		
		echo html_row([
			'class' => 'data-set password',
			'caption' => 'Password',
			'text' => html_password([
				'name' => 'password',
				'placeholder' => 'Password',
			]),
		]);
		?>
		<div class='buttons'>
			<input type="submit" value="LOGIN">
			<a href="/user/register" class="ui-btn ui-icon-action">REGISTER</a>
		</div>
	</form>
</div>