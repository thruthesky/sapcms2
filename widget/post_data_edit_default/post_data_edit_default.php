<?php
$config = post_config()->getCurrent();
$config = post_data()->getCurrent();

?>

<form>
    <input type="hidden" name="id" value="<?php echo $config->id; ?>">
    <input type="hidden" name="idx" value="<?php echo $post->id; ?>">
</form>



