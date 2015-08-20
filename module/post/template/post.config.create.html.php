<form action="/post/config/create_submit">
    Post configuration ID :
    <input type="text" name="id" value="<?php echo request('id'); ?>">

    Post configuration name :
    <input type="text" name="name" value="<?php echo request('name'); ?>">

    <input type="submit" value="CREATE A POST CONFIG">
</form>