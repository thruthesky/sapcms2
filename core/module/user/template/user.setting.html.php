<a href="/user/resign">R E S I G N</a><br>


<form method="post">
    <?php
    echo html_row([
        'caption' => 'Language',
        'text' => html_select([
            'name'=>'language',
            'options' => ['en'=>'English', 'ko'=>'Korean'],
        ]),
    ]);

    echo html_row([
        'caption' => 'Timezone',
        'text' => html_select_timezone(USER_TIMEZONE_1, session_get(USER_TIMEZONE_1))
    ]);

    ?>
    <input type="submit" value="SUBMIT">
</form>