<?php
include 'config.php';
include 'src/sapcms-library.php';
include 'src/Route.php';
include 'src/HTML.php';
include 'src/Markup.php';
include 'src/Javascript.php';
include 'src/error_reporting.php';
include 'src/System.php';
include 'src/Request.php';
include 'src/Response.php';


$system = System::load();


if ( $system->runOnCommandLineInterface() ) {
}
else {
    include 'etc/check/install.php';
    if ( $result = $system->check() ) Response::html($result);
}






