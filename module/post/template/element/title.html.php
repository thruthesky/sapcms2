<?php
echo html_row([
    'class' => 'title',
    'caption' => 'TITLE',
    'text' => html_input([
        'name' => 'title',
        'placeholder' => 'Input title',
        'value' => $title,
    ]),
]);