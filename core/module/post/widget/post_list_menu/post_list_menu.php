<?php
$user_id = login('id');
?>
<div class="buttons right">
<a class='write' href="<?php echo url_post_create();?>">Write a post</a>
<?php if( $user_id == 'admin' ){ ?>
<a class='settings' href="<?php echo url_post_config();?>">Settings</a>
<?php } ?>
</div>

