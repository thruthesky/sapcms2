<?php
echo html_row([
    'class' => 'title',
    'caption' => '제목',
    'text' => html_input([
        'name' => 'title',
        'placeholder' => '제목을 입력하십시오.',
        'value' => $title,
    ]),
]);