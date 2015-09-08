<form class="ajax-file-upload" method="post" enctype="multipart/form-data">
    <?php

    $title = login() ? 'User Information Update' : 'User Registration';
    ?>
    <h1><?php echo $title?></h1>

    <?php if ( login() ) { ?>

        <?php

        echo html_row([
            'caption' => 'User ID',
            'text' => user_form('id'),
        ]);



        $form_name = 'primary_photo';
        include template('user.photo');

        ?>
    <?php } else {


        ?>

        <?php echo html_row([
            'caption' => 'User ID',
            'text' => html_input(['type'=>'text', 'name'=>'id', 'value'=>user_form('id'), 'placeholder'=>'Input User ID']),
        ]);
        ?>
        <?php echo html_row([
            'caption' => 'Password',
            'text' => html_password(['name'=>'password', 'value'=>'', 'placeholder'=>'Input Password']),
        ]);
        ?>
    <?php } ?>



    <?php echo html_row([
        'caption' => 'Name',
        'text' => html_input(['type'=>'text', 'name'=>'name', 'value'=>user_form('name'), 'placeholder'=>'Input Name']),
    ]);
    ?>
    <?php echo html_row([
        'caption' => 'Email',
        'text' => html_input(['type'=>'email', 'name'=>'mail', 'value'=>user_form('mail'), 'placeholder'=>'Input Email']),
    ]);
    ?>

    <?php
    if( empty( $user ) ) $submit_text = "REGISTER";
    else $submit_text = "UDPATE";
    ?>
    <input type="submit" value="<?php echo $submit_text ?>">
    <a href="/" class="ui-btn ui-icon-action">CANCEL</a>
</form>