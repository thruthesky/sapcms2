<?php include template('post.admin.menu'); ?>
<form action="/admin/post/config/create_submit">
    Post configuration ID :
    <input type="text" name="id" value="<?php echo request('id'); ?>">

    Post configuration name :
    <input type="text" name="name" value="<?php echo request('name'); ?>">

    Post configuration Description :
    <input type="text" name="description" value="<?php echo request('description'); ?>">

    <input type="submit" value="CREATE A POST CONFIG">
</form>