<?php
add_css();
?>
<div class="user-form">

    <form class="ajax-file-upload" method="post" enctype="multipart/form-data">
        <input type="hidden" name="file_module" value="user">
        <input type="hidden" name="file_type" value="primary_photo">
        <input type="hidden" name="file_idx_target" value="<?php echo login('idx')?>">
        <input type="hidden" name="file_unique" value="1">
        <input type="hidden" name="file_finish" value="1">
        <input type="hidden" name="file_image_thumbnail_width" value="140">
        <input type="hidden" name="file_image_thumbnail_height" value="140">
        <input type="hidden" name="file_callback" value="callback_user_primary_photo_upload">
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



            $file_upload_form_name = 'primary_photo';
            $form_upload_single_file = true;
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

        <?php widget('philippines_province_city')?>

        <?php
        if( empty( $user ) ) $submit_text = "REGISTER";
        else $submit_text = "UDPATE";
        ?>

        <input type="submit" value="<?php echo $submit_text ?>">
        <a href="/" class="ui-btn ui-icon-action">CANCEL</a>
    </form>

</div>