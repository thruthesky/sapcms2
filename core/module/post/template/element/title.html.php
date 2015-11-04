<?php
echo html_row([
    'class' => 'title',
    'caption' => '제목',
    'text' => html_input([
        'name' => 'title',
        'placeholder' => 'Input title',
        'value' => $title,
    ]),
]);