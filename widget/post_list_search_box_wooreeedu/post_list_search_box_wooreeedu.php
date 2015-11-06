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
<section class="post-list-search-box wooreeedu">
    <form action="/post/search">
        <input type="hidden" name="id" value="<?php echo $id?>">

        <div class="text">
			<div class='checkbox-wrapper qn'>
				<input type="checkbox" id="qn" name="qn" value="y"<?php echo request('qn') == 'y' ? ' checked=1' : '' ?>>
				<label for="qn" class="user-id">User ID</label>
			</div>
			<div class='checkbox-wrapper qt'>
				<input type="checkbox" id='qt' name="qt" value="y"<?php echo request('qt') == 'y' ? ' checked=1' : '' ?>>
				<label for="qt" class="title">Title</label>
			</div>
			<div class='checkbox-wrapper qc'>
				<input type="checkbox" id='qc' name="qc" value="y"<?php echo request('qc') == 'y' ? ' checked=1' : '' ?>>
				<label for="qc" class="content">Content</label>
			</div>
        </div>

        <div class="input clearfix">
            <input type="text" name="q" value="<?php echo request('q')?>">
            <input type="image" src='/widget/post_list_search_box_wooreeedu/img/search_button.png'>
        </div>
    </form>
</section>