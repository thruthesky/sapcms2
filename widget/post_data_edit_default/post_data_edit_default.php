<?php
$config = post_config()->getCurrent();
$data = post_data()->getCurrent();
if ( $data ) {
    $idx = $data->idx;
}
else {
    $idx = 0;
}



?>
<form action="/post/edit/submit">
    <input type="hidden" name="id" value="<?php echo $config->id; ?>">
    <input type="hidden" name="idx" value="<?php echo $idx; ?>">
    Title :
    <input type="text" name="title" value="<?php echo request('title'); ?>">
    Content :
    <textarea name="content"><?php echo request('content'); ?></textarea>
    <input type="submit" value="UPDATE POST">
</form>



