<div class="login-box">
	<div class='logo'>	
		<img src='<?php echo sysconfig(URL_SITE); ?>/module/app/img/white_logo_wooreeedu.png?'/>
	</div>
    <form class="login">
        <div class='input-wrapper user'>
			<div class='bg-wrapper'>
				<div class='sprite user'></div>
			</div>
            <input type="text" name="id" value="" placeholder="아이디 입력">
        </div>
        <div class='input-wrapper password'>
			<div class='bg-wrapper'>
				<div class='sprite password'></div>
			</div>
            <input type="password" name="password" value="" placeholder="비밀번호 입력">
        </div>
        <div class='input-wrapper'>
            <input type="submit" value="로그인">
        </div>
		<div class='input-wrapper'>
			<span class="link register" route="register">회원가입</span>
		</div>
		<div class='forgot-password'>Forgot Password?</div>
    </form>
</div>
