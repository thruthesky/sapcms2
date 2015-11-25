<?php
	add_css('member.css');
	//widget('error');
?>

<div class='member-form-wrapper login han'>
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