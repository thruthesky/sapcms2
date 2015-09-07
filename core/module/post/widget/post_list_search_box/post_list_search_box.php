<?php
add_css();
add_javascript();
$config = post_config()->getCurrent();
if ( $config ) {
    $id = $config->get('id');
}
else {
    $id = null;
}
?>
<section class="post-list-search-box">
    <form action="/post/search">
        <input type="hidden" name="id" value="<?php echo $id?>">

        <div class="text">
            <input type="checkbox" id="qn" name="qn" value="y"<?php echo request('qn') == 'y' ? ' checked=1' : '' ?>>
            <label for="qn">User ID</label>
            <input type="checkbox" id='qt' name="qt" value="y"<?php echo request('qt') == 'y' ? ' checked=1' : '' ?>>
            <label for="qt"><span class="title">Title</label>
            <input type="checkbox" id='qc' name="qc" value="y"<?php echo request('qc') == 'y' ? ' checked=1' : '' ?>>
            <label for="qc"><span class="title">Content</label>
        </div>

        <div class="input">
            <input type="text" name="q" value="<?php echo request('q')?>">
            <input type="submit" value="SEARCH">
        </div>
    </form>
</section>