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
<script src="/core/etc/editor/ckeditor/ckeditor.js"></script>

<form action="/post/edit" method="post">
    <input type="hidden" name="id" value="<?php echo $config->id; ?>">
    <input type="hidden" name="idx" value="<?php echo $idx; ?>">

    <?php echo html_row([
        'class' => 'title',
        'caption' => 'TITLE',
        'text' => html_input([
            'name' => 'title',
            'placeholder' => 'Input title',
            'value' => $title,
        ]),
    ]); ?>


    <?php echo html_row([
        'class' => 'content',
        'caption' => 'CONTENT',
        'text' => html_textarea([
            'id' => 'contentEditor',
            'name' => 'content',
            'placeholder' => 'Input content',
            'value' => $content,
        ]),
    ]); ?>


    <input type="submit" value="UPDATE POST">
</form>
<script>
    CKEDITOR.replace( 'contentEditor', {
        uiColor: '#f0f0f0'
    } );
</script>


