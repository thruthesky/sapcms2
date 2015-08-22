<?php
    // add_javascript();
    //add_css();
if ( login() ) {
    include 'login-info.php';
}
else {
    include 'login-form.php';
}
