<div class="login-box">
	<div class='logo'>	
		<img src='<?php echo sysconfig(URL_SITE); ?>/module/app/img/white_logo_wooreeedu.png?'/>
	</div>
    <form class="login">
        <div class='input-wrapper user'>
			<div class='bg-wrapper'>
				<div class='sprite user'></div>
			</div>
            <input type="text" name="id" value="" placeholder="User ID">
        </div>
        <div class='input-wrapper password'>
			<div class='bg-wrapper'>
				<div class='sprite password'></div>
			</div>
            <input type="password" name="password" value="" placeholder="Password">
        </div>
        <div class='input-wrapper'>
            <input type="submit" value="Log In">
        </div>
		<div class='input-wrapper'>
			<span class="link register" route="register">Create an Account</span>
		</div>
		<div class='forgot-password'>Forgot Password?</div>
    </form>
</div>
