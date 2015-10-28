<?php
	add_css('member.css');
?>

<div class='member-form-wrapper register wooreeedu'>
	<div class='title'>Register</div>
	<form class='member-register-form member-form' method="post">
	<?php

		if( !empty( $variables['user'] ) ){
			echo "<h1>Admin Edit mode</h1>";
			echo html_hidden(['name'=>'idx', 'value'=>$variables['user']->get('idx')]);		
		}
	?>

	<?php if ( $user = login() ) { ?>

		<?php
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
		<?php
		if( empty( $user ) ) $submit_text = "REGISTER";
		else $submit_text = "UDPATE";
		?>
		<div class='buttons'>
			<input type="submit" value="<?php echo $submit_text ?>">
			<a href="/" class="ui-btn ui-icon-action">CANCEL</a>
		</div>
	</form>
</div>