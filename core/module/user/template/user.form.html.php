<?php
	/*
	*temp
	*year, month, day
	*/	
	for( $i = 1940; $i < date("Y",time() ); $i++ ) $year[$i] = $i;
	for( $i = 1; $i < 31; $i++ ) $day[$i] = $i;
	$month = 	[
				'1'=>'January',
				'2'=>'February',
				'3'=>'March',
				'4'=>'April',
				'5'=>'May',
				'6'=>'June',
				'7'=>'July',
				'8'=>'August',
				'9'=>'September',
				'10'=>'October',
				'11'=>'November',
				'12'=>'December',
				];


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
        'caption' => 'User ID',
        'text' => $user->get('id'),
    ]);
    ?>
<?php } else {

    $name = request('name');
    $mail = request('mail');

    ?>

    <?php echo html_row([
        'caption' => 'User ID',
        'text' => html_input(['type'=>'text', 'name'=>'id', 'value'=>request('id'), 'placeholder'=>'Input User ID']),
    ]);
    ?>
    <?php echo html_row([
        'caption' => 'Password',
        'text' => html_password(['name'=>'password', 'value'=>'', 'placeholder'=>'Input Password']),
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

<?php echo html_row([
    'caption' => 'Name',
    'text' => html_input(['type'=>'text', 'name'=>'name', 'value'=>$name, 'placeholder'=>'Input Name']),
]);
?>
<?php echo html_row([
    'caption' => 'Email',
    'text' => html_input(['type'=>'email', 'name'=>'mail', 'value'=>$mail, 'placeholder'=>'Input Email']),
]);
?>
<?php 
/*echo html_row([
    'caption' => 'Year',
    'text' => html_select(['type'=>'email', 'name'=>'mail', 'value'=>$mail]),
]);*/
?>
