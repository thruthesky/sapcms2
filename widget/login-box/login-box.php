<?php
    // add_javascript();
    //add_css();
if ( get_login_user() ) {
    echo "logged!";
}
?>
<form action="/user/login" method="post">
    <input type="text" name="id" value="">
    <input type="password" name="password" value="">
    <input type="submit" value="LOGIN">
</form>
