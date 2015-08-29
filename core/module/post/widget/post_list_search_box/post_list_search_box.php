<?php

$config = post_config()->getCurrent();
if ( $config ) {
    $id = $config->get('id');
}
else {
    $id = null;
}


?>
<form action="/post/search">
    <input type="hidden" name="id" value="<?php echo $id?>">
    <input type="checkbox" id="qn" name="qn" value="y"<?php echo request('qn') == 'y' ? ' checked=1' : '' ?>>
    <label for="qn">User ID</label>
    <input type="checkbox" id='qt' name="qt" value="y"<?php echo request('qt') == 'y' ? ' checked=1' : '' ?>>
    <label for="qt"><span class="title">Title</label>
    <input type="checkbox" id='qc' name="qc" value="y"<?php echo request('qc') == 'y' ? ' checked=1' : '' ?>>
    <label for="qc"><span class="title">Content</label>
    <input type="text" name="q" value="<?php echo request('q')?>">
    <input type="submit" value="SEARCH">
</form>
