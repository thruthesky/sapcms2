<div class='register-wrapper'>
	<div class='logo'>
		<img src='<?php echo sysconfig(URL_SITE)?>/module/app/img/register_logo.png'/>		
	</div>
	<div class='label'>Register</div>
	<form name="register" class='register'>
		<?php
		echo html_row([
			'caption' => 'User ID',
			'class' => 'id',
			'text' => html_input([
				'name' => 'id',				
				'placeholder' => '아이디',				
			])
		]);
		echo html_row([
			'caption' => 'Password',
			'class' => 'password',
			'text' => html_password([
				'name' => 'password',				
				'placeholder' => '비밀번호',				
			])
		]);
		echo html_row([
			'caption' => 'Name',
			'class' => 'name',
			'text' => html_input([
				'name' => 'name',				
				'placeholder' => '이름',
			])
		]);
		echo html_row([
			'caption' => 'mobile',
			'class' => 'mobile',
			'text' => html_input([
				'name' => 'mobile',				
				'type' => 'text',
				'placeholder' => 'Mobile',
			])
		]);
		echo html_row([
			'caption' => 'Email',
			'class' => 'mail',
			'text' => html_input([
				'name' => 'mail',				
				'type' => 'email',
				'placeholder' => '이메일',
			])
		]);
		?>
		<input type="submit" value="회원 가입">
	</form>
</div>