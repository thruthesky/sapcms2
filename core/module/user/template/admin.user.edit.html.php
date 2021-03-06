<?php
use sap\src\Date;

extract( module()->getVariables() );



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
            'text'=> html_select(['name'=>'birth_year', 'default'=>$user['birth_year'], 'options'=>Date::years()]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Month',
            'text'=> html_select(['name'=>'birth_month', 'default'=>$user['birth_month'], 'options'=>Date::months()]),
        ]
    ); ?>
	
    <?php echo html_row(
        [
            'caption'=>'Day',
            'text'=> html_select(['name'=>'birth_day', 'default'=>$user['birth_day'], 'options'=>Date::days()]),
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