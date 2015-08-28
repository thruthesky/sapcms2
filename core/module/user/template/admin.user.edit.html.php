<?php
extract( module()->getVariables() );

	for( $i = 1940; $i <= date( "Y",time() ); $i++ ){
		$years[$i] = $i;
	}	
	
	for( $i = 1; $i <= 31; $i++ ){
		$days[$i] = $i;
	}
	
	$months =	[
				"1"=>"January",
				"2"=>"February",
				"3"=>"March",
				"4"=>"April",
				"5"=>"May",
				"6"=>"June",
				"7"=>"July",
				"8"=>"August",
				"9"=>"September",
				"10"=>"October",
				"11"=>"November",
				"12"=>"December",
				];	
?>
<form  method="post">

    <?php echo html_row(['caption'=>'No.', 'text'=>$user['idx']]); ?>
    <?php echo html_row(['caption'=>'ID', 'text'=>$user['id']]); ?>
    <?php echo html_row(['caption'=>'Created', 'text'=>date('r', $user['created'])]); ?>
    <?php echo html_row(['caption'=>'Changed', 'text'=>date('r', $user['changed'])]); ?>

    @TODO Display Last login time and IP



    <?php echo html_row([
        'caption' => 'Password',
        'text' => html_password(['name'=>'password', 'value'=>'', 'placeholder'=>'Input Password']),
    ]);
    ?>


    <?php echo html_row(
        [
            'caption'=>'Name',
            'text'=> html_input(['name'=>'name', 'value'=>$user['name']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Nick Name',
            'text'=> html_input(['name'=>'nickname', 'value'=>$user['nickname']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Middle Name',
            'text'=> html_input(['name'=>'middle_name', 'value'=>$user['middle_name']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Last Name',
            'text'=> html_input(['name'=>'last_name', 'value'=>$user['last_name']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Domain',
            'text'=> html_input(['name'=>'domain', 'value'=>$user['domain']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Email',
            'text'=> html_input(['name'=>'mail', 'value'=>$user['mail']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Year',
            'text'=> html_select(['name'=>'birth_year', 'selected'=>$user['birth_year'], 'options'=>$years]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Month',
            'text'=> html_select(['name'=>'birth_month', 'selected'=>$user['birth_month'], 'options'=>$months]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Day',
            'text'=> html_select(['name'=>'birth_day', 'selected'=>$user['birth_day'], 'options'=>$days]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Landline',
            'text'=> html_input(['name'=>'landline', 'value'=>$user['landline']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Mobile',
            'text'=> html_input(['name'=>'mobile', 'value'=>$user['mobile']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Address',
            'text'=> html_input(['name'=>'address', 'value'=>$user['address']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Country',
            'text'=> html_input(['name'=>'country', 'value'=>$user['country']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Province',
            'text'=> html_input(['name'=>'province', 'value'=>$user['province']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'City',
            'text'=> html_input(['name'=>'city', 'value'=>$user['city']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'School',
            'text'=> html_input(['name'=>'school', 'value'=>$user['school']]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Work',
            'text'=> html_input(['name'=>'work', 'value'=>$user['work']]),
        ]
    ); ?>
	
    






    <?php
    if( empty( $user ) ) $submit_text = "REGISTER";
    else $submit_text = "UDPATE";
    ?>
    <input type="submit" value="<?php echo $submit_text ?>">
    <a href="/" class="ui-btn ui-icon-action">CANCEL</a>
</form>