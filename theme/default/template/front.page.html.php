<?php
//$data = data()->query("module='post' ORDER BY idx DESC");
//$file = post()->data()->files();
//$src = $file->url();

$src = post()->getLatestPostImage()->urlThumbnail(400, 200);

?>

<img src="<?php echo $src?>" style="width:100%;">

    <a href="/post">POST</a>
    <br>

    <?php echo date('r'); ?>


    <?php widget('login-box'); ?>

    Number of users: <?php echo user_count() ?>

    <?php echo beautify(systeminfo())?>


