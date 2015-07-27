<?php
include 'config.php';
include 'include/HTML.php';
include 'include/Markup.php';
include 'include/Javascript.php';
include 'include/error_reporting.php';
include 'include/System.php';
include 'include/Request.php';
include 'include/Response.php';

$system = System::load();

include 'etc/check/install.php';

if ( $result = $system->check() ) Response::html($result);



if ( $system->runOnCommandLineInterface() ) {

}
else {

}






