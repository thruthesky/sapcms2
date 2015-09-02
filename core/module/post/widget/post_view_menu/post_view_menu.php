<?php
add_css();
$url_list = post()->urlPostList(null, false);
$url_edit = post()->urlPostEdit();
$url_delete = post()->urlPostDelete();
?>


<a href="<?php echo $url_list?>">LIST</a>
<a href="<?php echo $url_edit?>">EDIT</a>
<a href="<?php echo $url_delete?>">DELETE</a>
<?php if ( is_post_admin() ) { ?>
<a href="<?php echo $url_delete?>">DELETE THREAD</a>
<?php } ?>

