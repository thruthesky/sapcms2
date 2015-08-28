<?php

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
            'caption'=>'Domain',
            'text'=> html_input(['name'=>'domain', 'value'=>$user['domain']]),
        ]
    ); ?>






    <?php
    if( empty( $user ) ) $submit_text = "REGISTER";
    else $submit_text = "UDPATE";
    ?>
    <input type="submit" value="<?php echo $submit_text ?>">
    <a href="/" class="ui-btn ui-icon-action">CANCEL</a>
</form>