<?php
$config = post_config()->getCurrent();
$data = post_data()->getCurrent();
if ( $data ) {
    $idx = $data->idx;
    $title = $data->get('title');
    $content = $data->get('content');
}
else {
    $idx = 0;
    $title = request('title');
    $content = request('content');
}



?>
<form action="/post/edit/submit">
    <input type="hidden" name="id" value="<?php echo $config->id; ?>">
    <input type="hidden" name="idx" value="<?php echo $idx; ?>">
    Title :
    <input type="text" name="title" value="<?php echo $title ?>">
    Content :
    <textarea name="content"><?php echo $content ?></textarea>
    <input type="submit" value="UPDATE POST">
</form>



