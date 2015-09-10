
<h2>
    Url settings
</h2>
<form method="post" data-ajax="false">
    <input type="hidden" name="mode" value="submit">
    <?php
    echo html_input([
        'name' => URL_SITE,
        'label' => 'Input URL of the site :',
        'placeholder' => '',
        'value'=>config(URL_SITE)
    ]);?>

    <input type="submit" value="SUBMIT">
</form>
