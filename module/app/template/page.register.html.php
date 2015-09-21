<h1>Register</h1>

<form name="register">
    <?php
    echo html_row([
        'caption' => 'User ID',
        'text' => html_input([
            'name' => 'id',
            'placeholder' => 'User ID',
        ])
    ]);
    echo html_row([
        'caption' => 'Password',
        'text' => html_password([
            'name' => 'password',
            'placeholder' => 'Password',
        ])
    ]);
    echo html_row([
        'caption' => 'Name',
        'text' => html_input([
            'name' => 'name',
            'placeholder' => 'Name',
        ])
    ]);
    echo html_row([
        'caption' => 'Email',
        'text' => html_input([
            'name' => 'mail',
            'type' => 'email',
            'placeholder' => 'Email',
        ])
    ]);
    ?>
    <input type="submit" value="SUBMIT">
</form>