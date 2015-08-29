<?php
$config = post_config()->getCurrent();
$data = post_data()->getCurrent();


?>
<form action="/post/comment/edit/submit" method="post">
    <input type="hidden" name="idx" value="<?php echo $data->idx; ?>">

    <?php include template('element/hidden.variables'); ?>
    <?php
    echo html_row([
        'class' => 'content',
        'caption' => 'CONTENT',
        'text' => html_textarea([
            'name' => 'content',
            'placeholder' => 'Input content',
            'value' => $data->get('content'),
        ]),
    ]);
    ?>

    <input type="submit" value="UPDATE COMMENT">
</form>
