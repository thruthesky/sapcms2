<?php
echo html_row([
    'class' => 'content',
    'caption' => 'CONTENT',
    'text' => html_textarea([
        'id' => 'contentEditor',
        'name' => 'content',
        'placeholder' => 'Input content',
        'value' => $content,
    ]),
]);
