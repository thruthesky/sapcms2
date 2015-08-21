<?php
$timezone = session_get(USER_TIMEZONE_2);
if ( $timezone ) return;
if ( ! isset($_POST['offset']) || ! isset($_POST['dst'])) {
    add_javascript();
}
else {
    include 'timezone_function.php';
    $timezone = detect_timezone_id($_POST['offset'], $_POST['dst']);
    session_set(USER_TIMEZONE_2, $timezone);
    echo json_encode($timezone);
}



