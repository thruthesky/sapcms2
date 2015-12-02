<?php
	add_css('member.css');
	//widget('error');
?>

<div class='member-form-wrapper login nolja'>
	<div class='title'>회원 로그인</div>
	<form class='user-login-form member-form' action="/user/login" method="post" data-ajax="false">
		<!--
		<input type="text" name="id" value="">
		<input type="password" name="password" value="">
		-->
		<?php
		echo html_row([
			'class' => 'data-set username',
			'caption' => '아이디',
			'text' => html_input([
				'id' => 'id',
				'name' => 'id',
				'placeholder' => '아이디 입력',
			]),
		]);
		
		echo html_row([
			'class' => 'data-set password',
			'caption' => '비밀번호',
			'text' => html_password([
				'name' => 'password',
				'placeholder' => '비밀번호 입력',
			]),
		]);
		?>
		<div class='buttons'>
			<input type="submit" value="로그인">
			<a href="/user/register" class="ui-btn ui-icon-action">회원가입</a>
		</div>
	</form>
</div>

<!--[if lte IE 8]>
<style>
	.member-form-wrapper{
		padding:20px 20% 20px 20%;
	}
</style>
<![endif]-->
<!--[if lte IE 7]>
<style>
	.user-login-form.member-form .row.data-set > .text input[type='text'], .user-login-form.member-form .row.data-set > .text input[type='password']{
		height:13px;
	}
	
	.member-form .buttons input[type='submit']{
		height:40px;		
	}
	
	.member-form .buttons a{
		height:22px;
	}

	.user-login-form.member-form .buttons input[type='submit'], .user-login-form.member-form.member-form .buttons a{		
		width:45%;
		margin-bottom:0;
	}
	
	.user-login-form.member-form .forgot-password-wrapper{	
		margin-bottom:20px;
	}
</style>
<![endif]-->